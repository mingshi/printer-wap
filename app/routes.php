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
});
