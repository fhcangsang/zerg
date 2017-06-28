<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/6/28 0028
 * Time: 9:15
 */
namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use think\Controller;

class Token extends Controller
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
//        return $token;
    }
}