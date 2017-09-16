<?php
namespace app\index\controller;
use think\Controller;
use think\Validate;
use think\Loader;
use think\Request;
class Index extends Controller
{
	public function __construct(){
	    parent::__construct();
		echo '1';
	}
	
	public function _initialize(){
		echo '2';
	}
	
    public function index()
    {
         return json(['name'=>'mr','age'=>3,'color'=>'blue']);
        
    }

    public function validates(){
    	/*$validate = new Validate([
    			'name' => 'require|max:25',
                'email' => 'email'   
    		]);*/
        $data = [
            'name' => 'mysql_insert_id',
            'email' => 'hung.com'

        ];

        // $validate = Loader::validate('User');
        $validate = validate('User');
        if(!$validate->check($data)){
            dump($validate->getError());
        }
    }


    public function session1(Request $request){
        session_start();
        dump(session_id());
        session('name','Mr.Li');
        dump($request->session('name'));
        dump(session('?name'));
        dump(session_id());
    }

    public function session2(){
        session_start();
        dump(session_id());
        dump(session('name'));
        dump(session_id());
    }

    public function cook(){
        // cookie初始化 
            \think\Cookie::init(['prefix'=>'think_','expire'=>3600,'path'=>'/']); 
        // 指定当前前缀 
            \think\Cookie::prefix('think_'); 
        // 设置Cookie 有效期为 3600秒 
            \think\Cookie::set('uid','12',3600);
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
