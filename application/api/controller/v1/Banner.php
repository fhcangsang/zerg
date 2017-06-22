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
        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new BannerMissException();
        }
//        $c = config('setting.img_prefix');
        return $banner;
    }
}