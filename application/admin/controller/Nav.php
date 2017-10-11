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
use app\admin\validate\IDMustBeInt;
use think\Request;

class Nav extends BaseController
{
    /** 获取菜单
     * @return mixed
     */
    private $adminNavModel = '';

    public function _initialize()
    {
        parent::_initialize();
        $this->adminNavModel = new AdminNav();
    }

    public function index()
    {
        $menuList = Menu::getMenuList('tree', ['order_number' => 'asc']);
        $this->assign(['data' => $menuList]);
        return $this->fetch('nav/index');
    }

    /** 添加菜单
     * @param Request $request
     */
    public function add(Request $request)
    {
        $result = (new \app\admin\validate\Nav())->goCheck();
        if ($result != true) {
            $this->error($result);
        }
        $data = $request->post();
        /*$data =  [   //数据格式
            'pid' => '0',
            'name' => '权限管理',
            'mca' => 'admin/ShowNav/rule',
            'ico' => 'fa-',
        ];*/
        $this->adminNavModel->addData($data);
        $this->success('添加成功', url('admin/Nav/index'));
    }

    public function delete(Request $request)
    {
        $result = (new IDMustBeInt())->goCheck();
        if ($result != true) {
            $this->error($result);
        }
        $id = $request->param();

        $result = $this->adminNavModel->deleteData($id);
        if ($result) {
            $this->success('删除成功', url('admin/Nav/index'));
        } else {
            $this->error('请先删除子菜单');
        }

    }


    public function edit(Request $request)
    {
        $data = $request->post();
        $map = ['id' => $data['id']];
        unset($data['id']);
        $res = $this->adminNavModel->editData($map, $data);
        if ($res) {
            $this->success('修改成功', url('admin/Nav/index'));
        } else {
            $this->error('修改失败');
        }

    }


    public function order(Request $request)
    {
        $data = $request->post();
        $res = $this->adminNavModel->orderData($data);
        if ($res) {
            $this->success('排序成功', url('admin/Nav/index'));
        }
        else {
            $this->error('修改失败');
        }

    }
}