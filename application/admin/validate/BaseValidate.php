<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 14:25
 */

namespace app\admin\validate;


use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck($scene = ''){
        $request = Request::instance();
        $params = $request->param();
        if(empty($scene)){
            $result = $this->check($params);
        }else{
            $result = $this->scene($scene)->check($params);
        }
        if(!$result){
            return $error = $this->error;
//            return $error = $this->getError();
        }else{
            return true;
        }
    }
}