<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 9:31
 */
namespace app\api\service;

use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $data = [
            'appid' => $this->wxAppID,
            'secret' => $this->wxAppSecret,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $param = http_build_query($data);
        $this->wxLoginUrl = config('wx.login_url') . $param;
    }

    //通过code 获取 session_key 和 openid, 并生成token令牌
    public function get()
    {
        $result = curl_get($this->wxLoginUrl);//微信服务返回的openid,session_key,expire_in
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取 session_key 和 openid异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->granToken($wxResult);
            }

        }

    }

    /**
     * @param $wxResult
     * @throws WeChatException
     */
    private function processLoginError($wxResult)
    {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    //生成token 令牌
    private function granToken($wxResult)
    {
        $openid = $wxResult['openid'];
//        $session_key = $wxResult['session_key'];
        //查找user表 是否已存在 openid
        $user = UserModel::getByOpenID($openid);
        if ($user) {
            $uid = $user->id;
        } else {//user 不存在openid 添加新 用户
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    //新增用户
    /**
     * @param $openid
     * @return mixed
     */
    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    /**
     * @param $wxResult
     * @param $uid
     * 重组缓存数据
     */
    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;//代表APP用户的权限数值
        return $cachedValue;
    }

    /**
     * @param $cachedValue
     * @return string
     * @throws TokenException
     * 缓存数据 并返回 token
     */
    private function saveToCache($cachedValue)
    {
        $key = self::generateToken(); //以token 为键名
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key, $value, $expire_in);
        if (!$request) {
            throw new TokenException([
                'msg' => '服务器缓存错误',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

}