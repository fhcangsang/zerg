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
    //请求微信服务器预订单信息
    public function getPreOrder($id = ''){
        (new IDMustBePostiveInt())->goCheck();

        $payService = new PayService($id);
        return $payService->pay();
    }
}