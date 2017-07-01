<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/1 0001
 * Time: 11:23
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404; //HTTP 状态码
    public $msg = '用户不存在'; //具体信息
    public $errorCode = 60000; //自定义错误码
}