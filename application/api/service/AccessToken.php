<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/9/18
 * Time: 13:24
 */

namespace app\api\service;


use app\lib\exception\WeChatException;
use think\Exception;

class AccessToken
{
    /**
     * token 管理类
     */
    private $access_token_url;
    const TOKEN_CACHE_KEY = 'access';
    const TOKEN_EXPIRE_IN = 7000;

    /**
     *
     */
    public function __construct()
    {
        $data = [
            'grant_type'=>'client_credential',
            'appid'=>config('wx.app_id'),
            'secret'=>config('wx.app_secret')
        ];

        $param = http_build_query($data);

        $this->access_token_url = config('wx.access_token_url').$param;
    }

    /**
     * @return mixed|null
     * @throws Exception
     */
    public function get()
    {
        $token = $this->getFormCache();
        if(!$token){
            $token = $this->getFormWxServer();
        }
        return $token;
    }

    /**
     * @return mixed|null
     */
    private function getFormCache(){
        $token = cache(self::TOKEN_CACHE_KEY);
        if(!$token){
            return null;
        }
        return $token;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getFormWxServer(){
        $token = curl_get($this->access_token_url);
        $token = json_decode($token,true);
        if(empty($token)){
            throw new Exception('获取access_token失败');
        }
        else{
            $fag = array_key_exists('errcode',$token);
            if($fag){
                throw new Exception($token['errmsg']);
            }
        }

        $this->saveCache($token['access_token']);
        return $token['access_token'];
    }

    private function saveCache($token){
        cache(self::TOKEN_CACHE_KEY,$token,self::TOKEN_EXPIRE_IN);
    }
}