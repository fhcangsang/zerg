<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 19:21
 */

namespace app\admin\controller;


use app\admin\model\AdminNav;
use app\admin\service\Menu;
use think\Request;

class Nav extends BaseController
{
    /**
     * @return mixed
     */
    public function index()
    {
        $menuList = Menu::getMenuList('tree',['order_number'=>'asc']);
        $this->assign(['data'=>$menuList]);
        return $this->fetch('nav/index');
    }

    /**
     * @param Request $request
     */
    public function add(Request $request){
        $data = $request->post();
        $adminNav = new AdminNav();
        $res = $adminNav->addData($adminNav,$data);
        dump($res);
    }
}