<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 14:28
 */

namespace app\admin\controller;


use app\admin\model\AdminUsers;
use app\admin\service\UserLogin;
use app\admin\validate\User;
use think\Request;

class Login extends BaseController
{
    /**
     * @return mixed
     * 登陆页面
     */
    public function index(){
        return $this->fetch('login/index');
    }

    public function login(Request $request){
        $result = (new User())->goCheck('login');
        if($result !== true){
            $this->error($result);
        }
        $param = $request->post();
        $res = UserLogin::setLoginStatus($param);
        if(isset($res)){
            $this->success('登录成功、前往管理后台',url('admin/Index/index'));
        }
    }

    public function logout(){
        session('user',null);
//        dump(session('user'));
        $this->success('退出成功、前往登录页面',url('admin/login/index'));
    }

}