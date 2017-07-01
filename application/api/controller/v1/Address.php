<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/30 0030
 * Time: 17:04
 */

namespace app\api\controller\v1;


use app\api\validate\AddressNew;
use think\Controller;

class Address extends Controller
{
    //创建或更新地址
    public function createOrUpdateAddress()
    {
        (new AddressNew())->goCheck();
    }
}