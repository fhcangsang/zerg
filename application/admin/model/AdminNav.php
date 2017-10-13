<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/7 0007
 * Time: 22:40
 */

namespace app\admin\model;


class AdminNav extends BaseModel
{
    /**
     * @param array $order
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAdminNav($order = [])
    {
//        $order = ['order_number'=>'desc'];
        if (empty($order)) {
            $nav = self::select();
        } else {
            $nav = self::order($order)->select();
        }

        return $nav;
    }

    /**
     * @param $data
     * @return false|int
     */
    public static function addData($data)
    {
        foreach ($data as $k => $v) {
            $data[$k] = trim($v);
        }
        return self::create($data);//返回模型实例对象
    }

    /**
     * @param $map
     * @return bool
     */
    public static function deleteData($map)
    {
        //$map = ['id'=>1];
        $count = self::where('pid','=',$map['id'])->count();
        if ($count !== 0) {
            return false;
        }
        self::destroy(function ($query) use($map){
           $query->where($map);
        });
        return true;
    }

    /**
     * @param $map
     * @param $data
     * @return false|int
     */
    public static function editData($map, $data)
    {
//        $result = $this->isUpdate(true)->save($data, $map);
        $result = self::update($data,$map);//返回模型对象实例
        return $result;
    }

    public static function orderData($data, $id = 'id', $order = 'order_number')
    {
        foreach ($data as $k => $v) {
            $v = empty($v) ? null : $v;
            self::update([$order=>$v],[$id => $k]);
        }
        return true;
    }
}