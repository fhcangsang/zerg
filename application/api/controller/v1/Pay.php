<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/5 0005
 * Time: 17:21
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    /**
     * 请求微信服务器预订单信息
     * @param string $id
     * @return \|array
     * @throws \app\lib\exception\ParameterException
     */
    public function getPreOrder($id = ''){
        (new IDMustBePostiveInt())->goCheck();

        $payService = new PayService($id);
        return $payService->pay();
    }

    public function receiveNotify(){
        //+-----------------------
        //小程序支付完成,回调方法.通知频率为15/15/30/180/1800/1800/1800/1800/3600，单位：秒
        //采用数据锁进行并发控制,签名验证,并校验返回的订单金额是否与商户侧的订单金额一致
        //1.检查库存量,超卖,已支付缺货
        //2.更新订单status状态
        //3.减库存
        //+-----------------------

        $notify = new \WxPayNotify();
        $notify->Handle();
    }
}