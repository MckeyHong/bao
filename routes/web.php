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

Route::group(['namespace' => 'Web', 'middleware' => 'auth:web'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/withdrawal', 'WithdrawalController@index');
    Route::get('/record', 'RecordController@index');
    Route::get('/rule', 'RuleController@index');
});

Route::group(['namespace' => 'Web'], function () {
    Route::get('/member/redirect', 'MemberController@redirect');
});
