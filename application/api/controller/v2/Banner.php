<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/23 0023
 * Time: 9:33
 */
namespace app\api\controller\v2;

use think\Controller;

class Banner extends Controller
{
    public function getBanner($id)
    {
        return 'this is v2 version';
    }
}