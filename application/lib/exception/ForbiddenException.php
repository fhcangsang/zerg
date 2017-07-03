<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/3 0003
 * Time: 10:00
 */

namespace app\lib\exception;


use app\api\model\BaseModel;

class ForbiddenException extends BaseException
{
    public $code = 403; //HTTP 状态码
    public $msg = '无权访问'; //具体信息
    public $errorCode = 10001; //自定义错误码
}