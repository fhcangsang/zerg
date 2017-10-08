<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use app\admin\model\AdminNav;
use app\admin\service\Menu;
use think\Controller;
use think\Validate;
use think\Loader;
use think\Request;
class Index extends BaseController
{
    public function index(){
        $menu =Menu::getMenuList('level');
        if(!$menu){
            $this->error('未知错误');
        }
        $assign = ['data' => $menu];
        $this->assign($assign);
        return $this->fetch('index/index');
//        return view('index/index');
    }

    public function welcome(){
        return $this->display();
    }
    
}
