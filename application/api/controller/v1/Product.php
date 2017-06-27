<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/26 0026
 * Time: 17:51
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\lib\exception\ProductException;
use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{
    /**获取最近产品
     * @param int $count
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \app\lib\exception\ParameterException
     */
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $result = ProductModel::getMostRecent($count);

        if ($result->isEmpty()) {
            throw new ProductException();
        }
        /*$collection = collection($result); //数组转换为数据集对象,或者修改database.php配置文件让其直接返回数据集
        $result = $collection->hidden(['summary']);*/
        $result = $result->hidden(['summary']);
        return $result;
    }
}