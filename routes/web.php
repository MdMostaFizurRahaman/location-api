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


Route::group(['middleware' =>['request_logger']], function(){
    Route::get('/getLocation','LocationController@getLocation');
    Route::post('/getLocation','LocationController@getLocationPost');
});


Route::get('/post', "LocationController@post");

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function(){
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/', 'HomeController@index')->name('home');
});
