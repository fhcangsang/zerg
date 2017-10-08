<?php
namespace app\admin\validate;
use think\Validate;
/**
* 
*/
class User extends BaseValidate
{
	protected $rule = [
		'username' => 'require|min:3',
        'password' => 'require'
	];

    protected $message = [
       'username.min' => '用户名必须大于3位'
    ];
}
