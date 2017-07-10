<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/10 0010
 * Time: 10:08
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数',
    ];
}