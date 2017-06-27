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
    protected $hidden = ['delete_time', 'from', 'create_time', 'update_time', 'pivot', 'category_id', 'img_id',];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function images()
    {
        return $this->belongsToMany('Image', 'product_image', 'img_id', 'product_id');
    }

    /**
     * @param $count
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getMostRecent($count)
    {
        $products = self::with('images')->limit($count)
            ->order('create_time', 'desc')
            ->select();

        return $products;
    }
}