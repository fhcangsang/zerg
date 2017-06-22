<?php
namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    /**
     * 获取指定id的banner 信息
     * @url /banner/:id
     * @http_date() GET
     * @id banner
     */
    public function getBanner($id)
    {

        $validate = new IDMustBePostiveInt;
        $validate->goCheck();
//        $banner = BannerModel::getBannerByID($id);
//        $banner = BannerModel::with('items')->get($id); //BannerModel 若继承 Model 类 可以直接 使用 get() 默认查询条件是banner表的 主键
        $banner = BannerModel::with(['items','items.img'])->find($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}