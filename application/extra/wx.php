<?php
$request = \think\Request::instance();
$domain = $request->domain();
return [
    'app_id' => 'wxf758e4f77b87002b', //小程序id
    'app_secret' => '3a9f4b1820d4c10ba4b1ace1ca358a60',//小程序密钥
    //code 获取 session_key 和 openid的 url
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?',
    //微信支付 回调 url
    'notify_url' => $domain.'/api/v1/pay/notify',
    //微信小程序获取access_token的url
    'access_token_url' => 'https://api.weixin.qq.com/cgi-bin/token?'
];