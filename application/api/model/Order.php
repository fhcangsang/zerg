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

    public function getSnapImgAttr($value)
    {
        return config('setting.img_prefix') . $value;
    }

    public function setSnapImgAttr($value)
    {
        $prefix = config('setting.img_prefix');
        return str_replace($prefix, '', $value);
    }

    public function getSnapItemsAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
    public function getSnapAddressAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    /**
     * @param $uid
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     */
    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }
}