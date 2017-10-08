<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/7 0007
 * Time: 22:40
 */

namespace app\admin\model;


class AdminNav extends BaseModel {
    /**
     * @param string $order
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAdminNav($order = ''){
        if(empty($order)){
            $nav = self::select();
        }else{
            $nav = self::order('order_number',$order)->select();
        }

        return $nav;
    }
}