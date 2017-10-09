<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/7 0007
 * Time: 22:39
 */
namespace app\admin\model;

use think\Model;

class BaseModel extends Model
{
    /**
     * @param $data
     * @return false|int
     * 新增数据
     */
    public function addData($obj,$data)
    {
        foreach($data as $k=>$v){
            $data[$k] = trim($v);
        }
        return $obj->save($data);
    }
}