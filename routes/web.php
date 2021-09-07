<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// 前台 
// 前台 首页 显示
Route::get('/','home\IndexController@index');

Route::group(['prefix'=>'home'],function(){
	// 前台 列表页 显示
	Route::get('list/index/{flag}/{id}/{cname?}','home\ListController@index');

	// 前台 搜索页 显示
	Route::get('search/index','home\SearchController@index');

	// 前台 详情页 显示
	Route::get('detail/index/{aid}/{cid}/{cname}','home\DetailController@index');
    // 前台 文章 详情页 点赞 操作
	Route::get('detail/goodnum','home\DetailController@goodnum');

	// 前台 登录 显示
	Route::get('login/index','home\LoginController@index');
	// 前台 登录 操作
	Route::post('login/dologin','home\LoginController@dologin');
	// 前台 退出 操作
	Route::get('login/logout','home\LoginController@logout');

	// 前台 注册 显示
	Route::get('register/create','home\RegisterController@create');
	// 前台 注册 操作
	Route::post('register/store','home\RegisterController@store');
});



// 后台 登录 显示
Route::get('admin/login/index','admin\LoginController@index');
// 后台 登录 操作
Route::post('admin/login/doLogin','admin\LoginController@doLogin');

// 后台
Route::group(['prefix'=>'admin','middleware'=>'login'],function(){
	// 后台 退出 操作
	Route::get('login/logout','admin\LoginController@logout');	

	// 后台 主页 显示
	Route::get('index','admin\IndexController@index');
	// 后台 验证 token 操作
	Route::get('index/checkToken','admin\IndexController@checkToken');
	// 后台 修改 密码 操作
	Route::post('index/updatePwd','admin\IndexController@updatePwd');
	// 后台 修改 头像 操作
	Route::post('index/updatePrf/{id}','admin\IndexController@updatePrf');

	// 后台 用户 添加 显示
	Route::get('user/create','admin\UserController@create');
	// 后台 用户 添加 操作
	Route::post('user/store','admin\UserController@store');
	// 后台 用户 列表 显示
	Route::get('user/index','admin\UserController@index');
	// 后台 用户 删除 操作
	Route::get('user/destory','admin\UserController@destory');
	// 后台 用户 修改 显示
	Route::get('user/edit/{id}/{token}','admin\UserController@edit');
	// 后台 用户 修改 操作
	Route::post('user/update/{id}/{token}','admin\UserController@update');

	// 后台 栏目 添加 显示
	Route::get('cate/create/{id?}','admin\CateController@create');
	// 后台 栏目 添加 操作
	Route::post('cate/store','admin\CateController@store');
	// 后台 栏目 列表 显示
	Route::get('cate/index','admin\CateController@index');
	// 后台 栏目 修改 显示
	Route::get('cate/edit/{id}','admin\CateController@edit');
	// 后台 栏目 修改 操作
	Route::post('cate/update','admin\CateController@update');

	// 后台 轮播图 添加 显示
	Route::get('banner/create','admin\BannerController@create');
	// 后台 轮播图 添加 操作
	Route::post('banner/store','admin\BannerController@store');
	// 后台 轮播图 列表 显示
	Route::get('banner/index','admin\BannerController@index');
	// 后台 轮播图 删除 操作
	Route::get('banner/destory','admin\BannerController@destory');
	// 后台 轮播图 修改状态 操作
	Route::get('banner/changeStatus','admin\BannerController@changeStatus');
	// 后台 轮播图 修改 显示
	Route::get('banner/edit/{id}','admin\BannerController@edit');
	// 后台 轮播图 修改 操作
	Route::post('banner/update','admin\BannerController@update');

	// 后台 标签云 添加 显示
	Route::get('tag/create','admin\TagController@create');
	// 后台 标签云 添加 操作
	Route::post('tag/store','admin\TagController@store');
	// 后台 标签云 列表 显示
	Route::get('tag/index','admin\TagController@index');
	// 后台 标签云 删除 操作
	Route::get('tag/destory','admin\TagController@destory');
	// 后台 标签云 修改 显示
	Route::get('tag/edit/{id}','admin\TagController@edit');
	// 后台 标签云 修改 操作
	Route::post('tag/update/{id}','admin\TagController@update');

	// 后台 文章 添加 显示
	Route::get('article/create','admin\ArticleController@create');
	// 后台 文章 添加 操作
	Route::post('article/store','admin\ArticleController@store');
	// 后台 文章 列表 显示
	Route::get('article/index','admin\ArticleController@index');
	// 后台 文章 详情 显示
	Route::get('article/show','admin\ArticleController@show');
	// 后台 文章 删除 操作
	Route::get('article/destory','admin\ArticleController@destory');
	// 后台 文章 修改 显示
	Route::get('article/edit/{id}','admin\ArticleController@edit');
	// 后台 文章 修改 操作
	Route::post('article/update/{id}','admin\ArticleController@update');
});	
