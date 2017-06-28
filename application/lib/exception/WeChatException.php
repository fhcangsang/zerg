<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 10:50
 */

namespace app\lib\exception;


use app\api\validate\BaseValidate;

class WeChatException extends BaseException
{
    public $code = 404;
    public $msg = '';
    public $errorCode;
}