<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/11 0011
 * Time: 22:59
 */

namespace app\admin\validate;


class IDMustBeInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|IDMustBeInt',
    ];
    protected $message = [
        'id.IDMustBeInt' => 'id必须是正整数'
    ];
}