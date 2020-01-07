<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api', 'middleware' => ['api']], function () {
    // 會員登入驗證
    Route::post('/member/login', 'MemberController@login');
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'middleware' => ['auth:api']], function () {
    Route::post('/deposit', 'WebController@deposit');
    Route::post('/withdrawal', 'WebController@withdrawal');
    Route::get('/record', 'WebController@record');
});
