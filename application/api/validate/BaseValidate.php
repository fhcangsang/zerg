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
        $result = $this->batch()->check($params);
        if (!$result) {
            $error = $this->error;
            throw new ParameterException(['msg' => $error]);
//            throw new Exception($error);
        } else {
            return true;
        }
    }
}