<?php
namespace app\api\model;

use think\Db;
use think\Model;

/**
 *
 */
class Banner extends Model
{

    public static function getBannerByID($id)
    {
        //TODO:
        $result = Db::query('select * from `banner_item` where banner_id=?', [$id]);
        return $result;

    }
}