<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 9:29
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne('UserAddress','user_id','id');
    }
    /**
     * @param $openid
     * @return array|false|\PDOStatement|string|\think\Model
     * 根据openid 查找用户信息
     */
    public static function getByOpenID($openid)
    {
        $user = self::where('openid','=',$openid)->find();
        return $user;
    }

    /**
     * 根据id 查找用户信息
     * @param $uid
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getUserInfoByID($uid){
        $user = self::with('address')->find($uid);
        return $user;
    }

}