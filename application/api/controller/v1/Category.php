<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/27 0027
 * Time: 15:00
 */

namespace app\api\controller\v1;


use app\lib\exception\CategoryException;
use think\Controller;
use app\api\model\Category as CategoryModel;

class Category extends Controller
{
    /**获取分类
     * @return false|\PDOStatement|string|\think\Collection
     * @throws CategoryException
     */
    public function getAllCategories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->with('img')->select();

//        $categories = CategoryModel::all(null,'img',true);
        if($categories->isEmpty()){
            throw new CategoryException();
        }

        return $categories;
    }

}