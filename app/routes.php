<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/wx/scope_base', ['as' => 'wxScopeBase', 'uses' => 'WxController@scope_base']);
Route::any('/forbidden', ['as' => 'forbidden', 'uses' => 'ErrorController@forbidden']);
Route::group(
    array('before' => array('wxLogin')), function () {
        Route::any('/make/start', ['as' => 'makeStart', 'uses' => 'MakeController@start']);
        Route::any('/make/classes', ['as' => 'makeClasses', 'uses' => 'MakeController@classes']);
        Route::any('/make/templates', ['as' => 'makeTemplates', 'uses' => 'MakeController@templates']);
        Route::any('/make/template/info', ['as' => 'templateInfo', 'uses' => 'MakeController@templateInfo']);
        Route::any('/make/image', ['as' => 'makeImage', 'uses' => 'MakeController@image']);

        //我的
        Route::any('/my/albumList', ['as' => 'myAlbumList', 'uses' => 'MyController@albumList']);
        Route::any('/my/albumInfo', ['as' => 'myAlbumInfo', 'uses' => 'MyController@albumInfo']);
        Route::any('/my/orderList', ['as' => 'orderList', 'uses' => 'MyController@orderList']);

        //下单
        Route::any('/order/create', ['as' => 'orderCreate', 'uses' => 'OrderController@create']);

        //关于我们
        Route::any('/about', ['as' => 'about', 'uses' => 'AboutController@index']);
});

//一些ajax
Route::any('/ajax/get_images', ['as' => 'getImages', 'uses' => 'AjaxController@get_images']);
Route::any('/ajax/save', ['as' => 'saveImage', 'uses' => 'AjaxController@save']);
Route::any('/ajax/del_image', ['as' => 'delImage', 'uses' => 'AjaxController@del_image']);
Route::any('/ajax/createOrder', ['as' => 'ajaxCreateOrder', 'uses' => 'AjaxController@createOrder']);
