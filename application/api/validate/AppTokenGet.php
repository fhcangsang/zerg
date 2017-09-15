<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/9/15
 * Time: 17:35
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
        protected $rule = [
            'ac' => 'require|isNotEmpty',
            'se' => 'require|isNotEmpty'
        ];
        protected $message = [
            '账号或密码必填。。。'
        ];
}