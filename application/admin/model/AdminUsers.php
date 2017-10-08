<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 15:09
 */

namespace app\admin\model;


class AdminUsers extends BaseModel
{
    /**
     * @param array $condition
     * @return array|false|\PDOStatement|string|\think\Model
     * 获取用户信息
     */
    public  static function getUserInfo($condition){
        $username = $condition['username'];
        $user = self::where('username',$username)->find();
        return $user;
    }
}