<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/11 0011
 * Time: 23:07
 */

namespace app\admin\validate;


class Nav extends BaseValidate
{
    protected $rule = [
        'pid' =>'require',
        'name' =>'require',
        'mca' =>'require',
    ];
}