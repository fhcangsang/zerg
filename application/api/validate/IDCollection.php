<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/23 0023
 * Time: 13:57
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs',
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的正整数',
    ];

    /**
     * @param $value
     * @return bool
     */
    public function checkIDs($value)
    {
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if (true!==$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }

}