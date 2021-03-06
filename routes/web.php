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

Route::group(['middleware' => ['web']], function (){
    Route::group(['prefix' => 'auth'], function (){
        Route::get('login', array('as'=>'auth.login', 'uses'=>'AuthController@login'));
        Route::post('login', array('as' => 'login.attempt', 'uses' => 'AuthController@attempt'));

        Route::get('register', 'AuthController@register');
        Route::post('register', array('as'=>'register.create', 'uses'=>'AuthController@create'));

        Route::get('logout', 'AuthController@logout');
    });
    Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function (){
        Route::get('/', 'DashboardController@index');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('redirect', array('as'=>'redirect', 'uses'=>'FacebookController@redirect'));
Route::get('callback', 'FacebookController@callback');
