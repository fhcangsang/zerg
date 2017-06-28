<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 16:07
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'token已过期或无效token';
    public $errorCode = 10001;
}