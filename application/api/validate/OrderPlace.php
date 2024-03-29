<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/3 0003
 * Time: 16:31
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Validate;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'require|checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger',
    ];

    protected function checkProducts($values)
    {
        if(!is_array($values)){
            throw new ParameterException([
                'msg' => '订单参数错误'
            ]);
        }

        if(empty($values)){
            throw new ParameterException([
                'msg' => '订单列表不能为空'
            ]);
        }
        foreach($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    protected function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if(!$result){
            throw new ParameterException([
               'msg' => '订单参数错误'
            ]);
        }
    }

}