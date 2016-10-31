<?php

/*-- ----------------------------
      ---- 前台页面
-- ----------------------------*/

//Route::get('/', 'HomeController@index');
//Route::get('/article/{id}','HomeController@show');
//Route::get('/category/{id}','HomeController@category');
//Route::get('/tag/{id}','HomeController@tag');
//Route::get('/about',function(){
        //return '要不要增加个页面模型呢？';
//});

Route::group(['prefix' => 'home'],function()
{
    Route::get('/', 'HomeController@index');
    Route::get('/article/{id}','HomeController@show');
    Route::get('/category/{id}','HomeController@category');
    Route::get('/tag/{id}','HomeController@tag');
    Route::get('/about',function(){
        return '要不要增加个页面模型呢？';
    });
});

