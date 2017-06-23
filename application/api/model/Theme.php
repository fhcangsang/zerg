<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/23 0023
 * Time: 10:56
 */

namespace app\api\model;


class Theme extends BaseModel
{
    /**
     * @return \think\model\relation\BelongsTo
     */
    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImg()
    {
        return $this->belongsTo('image','head_img_id','id');
    }
}