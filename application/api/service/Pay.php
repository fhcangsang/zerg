<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/5 0005
 * Time: 18:05
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID) {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    /**
     * @return \|array
     * @throws OrderException
     * @throws TokenException
     */
    public function pay()
    {
        $this->checkOrderValid();
        //进行库存量检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']) {
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    /**
     * @return bool
     * @throws Exception
     * @throws OrderException
     * @throws TokenException
     */
    private function checkOrderValid()
    {
        //检测数据库是否存在该订单
        $order = OrderModel::where('id', '=', $this->orderID)->find();
        if (!$order) {
            throw new OrderException();
        }

        if (!Token::checkValidOperate($order->user_id)) { //订单号与当前用户是否匹配
            throw new TokenException([
                'msg' => '订单ID与用户ID不匹配',
                'errorCode' => 10003
            ]);
        }

        if ($order->status != OrderStatusEnum::UNPAID) { //检查订单是否已支付
            throw new OrderException([
                'msg' => '订单已支付过啦',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }

        $this->orderNO = $order->order_no;
        return true;
    }


    /**
     * //请求微信预订单
     * @param $totalPrice
     * @return \
     * @throws Exception
     * @throws TokenException
     */
    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        //参数设置
        $wxOrderData = new \WxPayUnifiedOrder();//统一下单输入对象
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('wx.notify_url'));

        return $this->getPaySignature($wxOrderData);
    }

    /**
     * //请求微信预订单
     * @param $wxOrderData
     * @return \-成功时返回
     * @throws \WxPayException
     */
    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
//        var_dump($wxOrder);
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result'] != 'SUCCESS') {
            Log::init([
                'type' => 'File',
                'path' => ROOT_PATH . 'log' . DS,
                'level' => ['error']
            ]);
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
            return false;
//            return $wxOrder;
        }
         //prepay_id
        $this->recordPreOrder($wxOrder);
        $rawValues = $this->sign($wxOrder);
        return $rawValues;
    }

    /**
     * @param $wxOrder
     * @return array
     */
    private function sign($wxOrder)
    {
        //生成签名,并返回小程序调起支付API 所需参数
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }

    /**
     * @param $wxOrder
     * 更新order表 prepay_id字段
     */
    private function recordPreOrder($wxOrder)
    {
        //prepay_id 用于向用户发送 模板消息
        (new OrderModel())->where('id', '=', $this->orderID)->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

}