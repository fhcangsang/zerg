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
use app\api\validate\OrderPlace;
use think\Controller;

class Order extends BaseController
{

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder']
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
        return $orderService->place($uid,$products);
    }
}