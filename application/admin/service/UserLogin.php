<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 15:20
 */

namespace app\admin\service;


use app\admin\model\AdminUsers;
use think\Exception;

class UserLogin
{
    /**
     * @param array $map
     * @return mixed
     * @throws Exception
     * 设置登录状态
     */
    public static function setLoginStatus($map)
    {
        $userInfo = AdminUsers::getUserInfo($map);

        if(!$userInfo){
            throw new Exception('用户名或密码错误');
        }
        if($userInfo['password']!=md5($map['password'])){
            throw new Exception('用户名或密码错误');
        }
        $data = [
            'id' => $userInfo['id'],
            'username' => $userInfo['username'],
            'avatar' => $userInfo['avatar'],
        ];
        session('user',$data);
        return $userInfo['id'];
    }

    /**
     * @return bool
     */
    public static function checkLogin(){
        $userInfo = session('user');
        if(!empty($userInfo['id'])){
            return true;
        }else{
            return false;
        }
    }

}