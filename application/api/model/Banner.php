<?php
namespace app\api\model;

use think\Db;
use think\Model;

/**
 *
 */
class Banner extends Model
{
    /**
     * @return \think\model\relation\HasMany
     * 一对多关联
     */
    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getBannerByID($id)
    {
        /*//无关联查询
//        $result = Db::query('select * from `banner_item` where banner_id=?', [$id]);
//        $result  = Db::table('banner_item')->where('banner_id','=',$id)->select();
//        $result = Db::table('banner_item')->where(function ($query) use ($id) {
//            $query->where('banner_id', '=', $id);
//        })->select();
        */
        $result = self::with(['items','items.img'])->find();
        return $result;

    }
}