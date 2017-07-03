<?php
/**
 * Created by PhpStorm.
 * User: yanfaone
 * Date: 2017/7/3 0003
 * Time: 14:40
 */

namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    /**
     * 权限认证
     * 管理员，用户都有的权限
     */
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    /**
     * 权限认证
     * 只有用户有的权限
     */
    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }
}