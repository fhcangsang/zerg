<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 15:26
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * @return string 生成token
     */
    public static function generateToken()
    {
        //生成32位随机字符串
        $randChars = getRandChar(32);
        //时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt
        $salt = config('secure.token_salt');
        return md5($randChars . $timestamp . $salt);
    }


    //根据token读取缓存的用户信息 获取指定的 key 值
    /**
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token'); //获取http header头的token值

        $userInfo = Cache::get($token);
        if (!$userInfo) { //判断缓存是否存在，验证token
            throw new TokenException();
        } else {
            if (!is_array($userInfo)) {
                $userInfo = json_decode($userInfo, true);
            }
            if (array_key_exists($key, $userInfo)) {
                return $userInfo[$key];
            } else {
                throw new Exception('获取的token变量不存在');
            }
        }
    }

    //获取用户UID
    public static function getCurrentUid()
    {
        return self::getCurrentTokenVar('uid');
    }

}