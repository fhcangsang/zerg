<?php
namespace app\api\behavior;
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/9/25
 * Time: 12:21
 */
use think\Response;
class CORS
{
   /* public function appInit(&$params)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET');
        if(request()->isOptions()){
            exit();
        }
    }*/
    public function run(&$params)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET,PUT');
        if(request()->isOptions()){
            exit();
        }
    }
}