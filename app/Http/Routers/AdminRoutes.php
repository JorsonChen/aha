<?php

/*
|--------------------------------------------------------------------------
| 后台路由
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*-- ----------------------------
      ---- 登陆注册
-- ----------------------------*/
//Route::get('auth/logout', 'Auth\AuthController@getLogout');

//Route::controllers([
    //'auth' => 'Auth\AuthController',
    //'password' => 'Auth\PasswordController',
//]);

/*-- ----------------------------
      ---- 后台管理
-- ----------------------------*/

//Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => 'auth'],function()
    //{
        ////Markdown上传图片
        //Route::post('/uploadImage','UploadController@uploadImage');

        //Route::get('/','AdminController@index');

        //Route::get('article/recycle', 'ArticleController@recycle');
        //Route::get('article/destroy/{id}/','ArticleController@destroy');
        //Route::get('article/restore/{id}', 'ArticleController@restore');
        //Route::get('article/delete/{id}', 'ArticleController@delete');
        //Route::resource('article','ArticleController');

        //Route::get('category/destroy/{id}/','CategoryController@destroy');
        //Route::resource('category','CategoryController');

        //Route::get('tags/destroy/{id}/','TagController@destroy');
        //Route::resource('tags','TagController');

    //});


Route::get('admin/index', ['as' => 'admin.index', 'middleware' => ['auth','menu'], 'uses'=>'IndexController@index']);

$this->group(['prefix' => '/admin'], function () {
    Route::auth();
});

$router->group(['middleware' => ['auth','authAdmin','menu']], function () {
    //权限管理路由
    Route::get('admin/permission/{cid}/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::get('admin/permission/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::post('admin/permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']); //查询

    Route::resource('admin/permission', 'PermissionController');
    Route::put('admin/permission/update', ['as' => 'admin.permission.edit', 'uses' => 'PermissionController@update']); //修改
    Route::post('admin/permission/store', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@store']); //添加


    //角色管理路由
    Route::get('admin/role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::post('admin/role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::resource('admin/role', 'RoleController');
    Route::put('admin/role/update', ['as' => 'admin.role.edit', 'uses' => 'RoleController@update']); //修改
    Route::post('admin/role/store', ['as' => 'admin.role.create', 'uses' => 'RoleController@store']); //添加


    //用户管理路由
    Route::get('admin/user/manage', ['as' => 'admin.user.manage', 'uses' => 'UserController@index']);  //用户管理
    Route::post('admin/user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::resource('admin/user', 'UserController');
    Route::put('admin/user/update', ['as' => 'admin.user.edit', 'uses' => 'UserController@update']); //修改
    Route::post('admin/user/store', ['as' => 'admin.user.create', 'uses' => 'UserController@store']); //添加


    //文章管理路由
    Route::get('admin/article/manage', ['as' => 'admin.article.manage', 'uses' => 'ArticleController@index']);  //文章管理
    Route::get('admin/article/index', ['as' => 'admin.article.index', 'uses' => 'ArticleController@index']); 
    Route::resource('admin/article', 'ArticleController');
    Route::put('admin/article/update', ['as' => 'admin.article.edit', 'uses' => 'ArticleController@update']); //修改
    Route::post('admin/article/store', ['as' => 'admin.article.create', 'uses' => 'ArticleController@store']); //添加




});

Route::get('admin', function () {
    return redirect('/admin/index');
});

Route::auth();
