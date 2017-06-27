<?php
namespace app\index\controller;
use think\Validate;
use think\Loader;
use think\Request;
class Index
{
    public function index()
    {
         return json(['name'=>'mr','age'=>3,'color'=>'blue']);
        
    }

    public function validate(){
    	/*$validate = new Validate([
    			'name' => 'require|max:25',
                'email' => 'email'   
    		]);*/
        $data = [
            'name' => 'mysql_insert_id',
            'email' => 'haungqq.com'

        ];

        // $validate = Loader::validate('User');
        $validate = validate('User');
        if(!$validate->check($data)){
            dump($validate->getError());
        }
    }


    public function sess(){
        session('name','Mr.Li');
        dump(session('name'));
        dump(session('?name'));
    }

    public function sess2(){
        dump(session('name'));
    }

    public function cook(){
        // cookie初始化 
            \think\Cookie::init(['prefix'=>'think_','expire'=>3600,'path'=>'/']); 
        // 指定当前前缀 
            \think\Cookie::prefix('think_'); 
        // 设置Cookie 有效期为 3600秒 
            \think\Cookie::set('name','value',3600); 
        // 获取指定前缀的cookie值 
        return \think\Cookie::get('name','think_');
    }

    public function test($id,$name,$age){
        dump($_GET);
        dump($_POST);
        dump($id);
        dump($name);
        dump($age);
        $request = Request::instance();
        dump($request->param());
    }

}
