<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/7 0007
 * Time: 22:26
 */

namespace app\admin\controller;


use Auth\Auth;
use think\Controller;
use think\Request;

class BaseController extends Controller {
    public function _initialize(){
        parent::_initialize();
        $request = Request::instance();
        $rule_name = $request->module().'/'.$request->controller().'/'.$request->action();
        $no_check = ['admin/Login/index','admin/Login/login','admin/Login/logout'];
        if(in_array($rule_name,$no_check)){
            return true;
        }
        $auth = new Auth();
        $check = $auth->check($rule_name,session('user.id'));
        if(!$check){
            $this->error('没有权限');
        }
    }
}