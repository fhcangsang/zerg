<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*return [
    '__pattern__' => [
        'name' => '\w+',
        'id' => '\d+'
    ],
   '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/
use think\Route;

Route::rule('test/:id', 'index/Index/test');

//http://test.tp5.com/api/v1/banner/1
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

//http://test.tp5.com/api/v1/theme?ids=1,2,3
Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');
//http://test.tp5.com/api/v1/theme/2
Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');


//http://test.tp5.com/api/v1/product/by_category?id=2
Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');
//http://test.tp5.com/api/v1/product/11
Route::get('api/:version/product/:id', 'api/:version.Product/getOne',[],['id'=>'^(-?\d+)(\.\d+)?']);
//http://test.tp5.com/api/v1/product/recent?count=3
Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');

//http://test.tp5.com/api/v1/category/all
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');

//http://test.tp5.com/api/v1/token/user  post 传参 {"code":"0038DXpA1m0D9i0eeeoA1nn2qA18DXpQ"}
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

//http://test.tp5.com/api/v1/address  参数 header传 token值,post传地址等信息
Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');

//http://test.tp5.com/api/v1/order  参数 header传 token值
Route::post('api/:version/order','api/:version.Order/placeOrder');

//http://test.tp5.com/api/v1/pay/pre_order  参数 header传 token值,post传 id (订单id)
Route::post('api/:version/pay/pre_order','api/:version.Pay/getPreOrder');
//http://test.tp5.com/api/v1/pay/notify
Route::post('api/:version/pay/notify','api/:version.Pay/receiveNotify');