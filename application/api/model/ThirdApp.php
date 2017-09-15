<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/9/15
 * Time: 17:43
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac,$se){
        $app = self::where(['app_id'=>$ac])
            ->where(['app_secret'=>$se])
            ->find();
        return $app;
    }
}