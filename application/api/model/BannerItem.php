<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/20 0020
 * Time: 17:15
 */
namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    public function items() {
        return $this->hasMany('BannerItem','banner_id','id');
    }

}