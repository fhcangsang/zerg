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
    public function getAdminNav($order = [])
    {
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
    public function addData($data)
    {
        foreach ($data as $k => $v) {
            $data[$k] = trim($v);
        }
        return self::save($data);
    }

    /**
     * @param $map
     * @return bool
     */
    public function deleteData($map)
    {
        $count = $this->where(['pid' => $map['id']])->count();
        if ($count !== 0) {
            return false;
        }
        $this->where($map)->delete();
        return true;
    }

    /**
     * @param $map
     * @param $data
     * @return false|int
     */
    public function editData($map, $data)
    {
        $result = $this->isUpdate(true)->save($data, $map);
        return $result;
    }

    public function orderData($data, $id = 'id', $order = 'order_number')
    {
        foreach ($data as $k => $v) {
            $v = empty($v) ? null : $v;
            $this->isUpdate(true)->save([$order=>$v],[$id => $k]);
        }
        return true;
    }
}