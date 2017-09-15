<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/9/15
 * Time: 17:52
 */

namespace app\api\service;


use app\api\model\ThirdApp;
use app\lib\exception\TokenException;

class AppToken extends Token
{
    public function get($ac, $se)
    {
        $app = ThirdApp::check($ac, $se);
        if (!$app) {
            throw new TokenException([
                'msg' => '授权失败',
                'errorCode' => 10004
            ]);
        } else {
            $scope = $app->scope;
            $uid = $app->id;
            $value = compact('scope', 'uid');
            $token = $this->saveToCache($value);
            return $token;
        }
    }

    public function saveToCache($cacheValue)
    {
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config("setting.token_expire_in");
        $res = cache($key, $value, $expire_in);
        if (!$res) {
            throw new TokenException([
                'msg' => '服务器缓存出错',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }
}