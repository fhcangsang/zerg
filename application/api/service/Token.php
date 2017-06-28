<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 15:26
 */

namespace app\api\service;


class Token
{
    public static function generateToken(){
        //生成32位随机字符串
        $randChars = getRandChar(32);
        //时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

}