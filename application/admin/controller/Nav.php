<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 19:21
 */

namespace app\admin\controller;


use app\admin\service\Menu;

class Nav extends BaseController
{
    public function index()
    {
        $menuList = Menu::getMenuList('tree',['order_number'=>'asc']);
        $this->assign(['data'=>$menuList]);
        return $this->fetch('nav/index');
    }

    public function add(){
        
    }
}