<?php
namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    //获取http传入的参数
    //检验参数
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();
        $result = $this->check($params);
        if (!$result) {
            $error = $this->error;
            throw new ParameterException(['msg' => $error]);
//            throw new Exception($error);
        } else {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $date = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
//            return $field . '必须是正整数';
            return false;
        }
    }

    protected function isNotEmpty($value,$rule='',$date='',$field=''){
       /* if(empty($value)){
            return false;
        }else{
            return true;
        }*/

        return empty($value) ? false : true;
    }
}