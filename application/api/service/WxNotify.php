<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/7 0007
 * Time: 9:56
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];//订单号
            try {
                $order = (new OrderModel)->where('order_no', '=', $orderNo);//订单详情
                if ($order['status'] == 1) {//未支付的订单才去处理
                    $orderService = new Order();
                    $stockStatus = $orderService->checkOrderStock($order['id']);//检查库存量
                    if ($stockStatus['pass']) {
                        $this->updateOrderStatus($order['id'], true);//更新订单状态
                        $this->reduceStock($stockStatus);//减库存
                    }
                }
            } catch (\WxPayException $e) {

            }
        }

    }

    /**
     * @param $orderID
     * @param $success
     * 更新订单状态
     */
    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        (new OrderModel())->where('id', '=', $orderID)->update(['status' => $status]);
    }

    /**
     * @param $stockStatus
     * @throws \think\Exception
     * 减库存
     */
    private function reduceStock($stockStatus)
    {
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            //$singlePStatus['count'];用户购买某个商品的数量
            (new Product())->where('id', '=', $singlePStatus['id'])->setDec('status', $singlePStatus['count']);//tp5直接对某个字段进行减少
        }
    }
}