<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/23 0023
 * Time: 10:54
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
    /**
     * @url /theme/ids?id1,id2,id3  获取专题列表
     * @param string $ids
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ThemeException
     * @throws \app\lib\exception\ParameterException
     */
    public function getSimpleList($ids = '')
    {
        /*$validate = new IDCollection();
        $validate->goCheck();*/
        (new IDCollection())->goCheck();

        $lists = ThemeModel::getSimpleList($ids);
        if (!$lists) {
            throw new ThemeException();
        }
        return $lists;
    }

    /**
     * @param $id 获取指定id 的专题（包含的商品）
     */
    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
    }
}