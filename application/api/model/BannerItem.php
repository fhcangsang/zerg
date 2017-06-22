<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/20 0020
 * Time: 17:15
 */
namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time', 'update_time'];

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}