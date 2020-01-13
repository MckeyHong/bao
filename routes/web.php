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

Route::group(['prefix' => 'ctl'], function () {
    Auth::routes();
    // 已登入
    Route::group(['namespace' => 'Admin', 'middleware' => ['auth:user']], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        // 平台管理
        Route::group(['middleware' => 'permission'], function () {
            Route::group(['prefix' => 'platform', 'namespace' => 'Platform'], function () {
                Route::get('/list', 'PlatformListController@index');
                Route::get('/activity', 'PlatformActivityController@index');
            });

            // 會員管理
            Route::group(['prefix' => 'member', 'namespace' => 'Member'], function () {
                Route::get('/list', 'MemberListController@index');
                Route::get('/transfer', 'MemberTransferController@index');
                Route::get('/login', 'MemberLoginController@index');
            });

            // 統計報表
            Route::group(['prefix' => 'report', 'namespace' => 'Report'], function () {
                Route::get('/member', 'ReportMemberController@index');
                Route::get('/interest', 'ReportInterestController@index');
            });

            // 系統管理
            Route::group(['prefix' => 'system', 'namespace' => 'System'], function () {
                Route::get('/role', 'SystemRoleController@index');
                // 帳號管理
                Route::group(['prefix' => 'user'], function () {
                    Route::get('/', 'SystemUserController@index');
                    Route::get('/create', 'SystemUserController@getStore');
                    Route::get('/edit/{id}', 'SystemUserController@getEdit');
                    Route::post('/', 'SystemUserController@store');
                    Route::put('/{id}', 'SystemUserController@edit');
                    Route::delete('/{id}', 'SystemUserController@destroy');
                });
                // 登入日誌
                Route::get('/login', 'SystemLoginController@index');
                // 操作日誌
                Route::get('/operation', 'SystemOperationController@index');
            });
        });
    });
});
