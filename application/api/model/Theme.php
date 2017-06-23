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
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];
    /**
     * @return \think\model\relation\BelongsTo
     * 关联模型Image
     */
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
    /**
     * @return \think\model\relation\BelongsTo
     * 关联模型Image
     */
    public function headImg()
    {
        return $this->belongsTo('image', 'head_img_id', 'id');
    }

    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    /**
     * @param $ids 获取专题列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getSimpleList($ids)
    {
        $ids = explode(',',$ids);
        $result = self::with(['topicImg','headImg'])->select($ids);
        return $result;
    }
}