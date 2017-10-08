<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/7 0007
 * Time: 22:53
 */
namespace app\admin\service;

use app\admin\model\AdminNav;
use Auth\Auth;

class Menu
{
    public static function getMenuList($type = 'tree',$order = '')
    {
        $menuList = AdminNav::getAdminNav($order)->toArray();
        if($type == 'tree'){
            $data = Data::tree($menuList,'name','id','pid');
        }elseif($type == 'level'){
            $data = Data::channelLevel($menuList,0,'&nbsp;','id');

            $uid = session('user.id');
            $auth = new Auth();
            //删除当前用户没有的权限菜单
            foreach($data as $k=>$v){
                if($auth->check($v['mca'],$uid)){
                    foreach($v['_data'] as $kk=>$vv){
                        if(!$auth->check($vv['mca'],$uid)){
                            unset($data[$k]['_data'][$kk]);
                        }
                    }
                }else{
                    unset($data[$k]);
                }
            }
        }

        return $data;
    }
}