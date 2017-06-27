<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/27 0027
 * Time: 12:27
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '请求的商品不存在';
    public $errorCode = 20000;

}