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

    /**微信类调用
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