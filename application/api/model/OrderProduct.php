<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/5 0005
 * Time: 10:03
 */

namespace app\api\model;


class OrderProduct extends BaseModel
{
    protected $hidden = ['delete_time', 'create_time', 'update_time'];
    public function product(){
        return $this->hasOne('Product','id','product_id');
    }
}