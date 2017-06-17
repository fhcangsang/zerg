<?php
namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    public $code = 400; //HTTP 状态码
    public $msg = '参数错误'; //具体信息
    public $errorCode = 10000; //自定义错误码
}