<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    /**转换成完整的图片url
     * @param $value
     * @param $data
     * @return string
     */
    protected function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix') . $value;
        }

        return $finalUrl;
    }
}
