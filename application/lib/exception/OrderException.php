<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/4 0004
 * Time: 11:24
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404; //HTTP 状态码
    public $msg = '订单不存在'; //具体信息
    public $errorCode = 80000; //自定义错误码
}