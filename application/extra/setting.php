<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/22 0022
 * Time: 14:43
 */
$request = \think\Request::instance();
$domain = $request->domain();
return [
    'img_prefix' =>$domain.'/images',
    'token_expire_in' => 7200
];