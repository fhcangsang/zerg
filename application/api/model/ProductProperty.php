<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/29 0029
 * Time: 10:17
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'product_id'];
}