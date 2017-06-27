<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/16 0016
 * Time: 15:07
 */
namespace app\lib\exception;

use think\Exception;

class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;

    /**验证类调用
     * @param array $params
     */
    public function __construct($params = []){

        if(!is_array($params)){
            return ;
//            throw new Exception('参数错误!!!');
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}