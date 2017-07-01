<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/30 0030
 * Time: 17:08
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty'
    ];
    protected $message = [
      'mobile.isMobile' => '手机号格式错误'
    ];
}