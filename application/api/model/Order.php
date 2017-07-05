<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/5 0005
 * Time: 9:37
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];

    public function setSnapImgAttr($value)
    {
        return str_replace('http://test.tp5.com/images','',$value);
    }
}