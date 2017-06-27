<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/26 0026
 * Time: 17:51
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\lib\exception\ParameterException;
use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    /**
     * @param int $count
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \app\lib\exception\ParameterException
     */
    public function getRecent($count=15)
    {
        (new Count())->goCheck();
        $result = ProductModel::getMostRecent($count);

        if(!$result){
            throw new ParameterException();
        }
        $collection = collection($result);
        $result = $collection->hidden(['summary']);
        return $result;
    }
}