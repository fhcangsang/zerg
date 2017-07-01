<?php
namespace app\api\validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];

    protected $message = [
        'id.isPositiveInteger' => 'id必须是正整数'
    ];
}