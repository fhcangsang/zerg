<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/3 0003
 * Time: 13:48
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Token as TokenService;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;
use think\Controller;
use app\api\model\Order as OrderModel;

class Order extends BaseController
{

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getSummaryByUser, getDetail']
    ];

    /**下订单
     * @return array -下单结果，成功失败都有返回
     * @throws \app\lib\exception\ParameterException
     */
    public function placeOrder()
    {

        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $orderService = new \app\api\service\Order();
        return $orderService->place($uid, $products);
    }

    /**
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummaryByUser($page = 1, $size = 15)
    {
        //获取订单列表
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address', 'prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }


    public function getDetail($id)
    {
        //订单详情
        (new IDMustBePostiveInt())->goCheck();
        /*
         刚刚开始 下单是 没有将商品的price ，main_img_url存入订单表中
        因此取出时去关联，很麻烦
        $orderModel = new OrderModel();
        $orderDetail = $orderModel->with(['products','products.product'])->find($id)->toArray();
        foreach($orderDetail['products']  as $k=>$v){
            if($orderDetail['snap_items'][$k]['id'] == $v['product_id']){
                $orderDetail['snap_items'][$k]['price']= $v['img']['price'];
                $orderDetail['snap_items'][$k]['main_img_url'] = $v['img']['main_img_url'];
            }
        }
        unset($orderDetail['products']);
        unset($orderDetail['prepay_id']);
        if (!$orderDetail) {
            throw new OrderException();
        }
        return $orderDetail;*/
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);

    }
}