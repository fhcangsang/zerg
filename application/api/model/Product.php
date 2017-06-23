<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/23 0023
 * Time: 10:55
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['delete_time','from','create_time','update_time'];

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public function images(){
        return $this->belongsToMany('Image','product_image','img_id','product_id');
    }

}