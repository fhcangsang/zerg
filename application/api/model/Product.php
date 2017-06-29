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
    protected $hidden = ['delete_time', 'from', 'create_time', 'update_time', 'category_id', 'img_id',];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function images()
    {
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty','product_id','id');
    }

    /**
     * 获取近期产品
     * @param $count
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time', 'desc')
            ->select();

        return $products;
    }

    //获取指定分类下的所有产品
    public static function getProductsByCategoryID($id)
    {
        $products = self::where(['category_id' => $id])
            ->select();
        return $products;
    }

    //商品详情
    public static function  getProductDetail($id)
    {
//        $product = self::with(['images','properties','images.imgUrl'])->find($id);
        $product = self::with(['images'=>function($query){
            $query->with(['imgUrl'])->order('order','asc');
        },'properties'])->find($id);
        return $product;
    }
}