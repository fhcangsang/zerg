<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/27 0027
 * Time: 9:14
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule =  [
      'count' => 'isPositiveInteger|between:1,15'
    ];

    protected $message = [
        'count' => 'count参数必须是1~15的正整数',
    ];
}