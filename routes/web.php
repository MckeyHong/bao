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
        // 首頁資訊
        Route::get('/home', 'HomeController@index')->name('home');

        // 個人資訊
        Route::group(['prefix' => 'system', 'namespace' => 'System'], function () {
            Route::get('/profile', 'SystemProfileController@index');
            Route::put('/profile', 'SystemProfileController@edit');
        });

        // 功能權限
        Route::group(['middleware' => 'permission'], function () {
            // 平台管理
            Route::group(['prefix' => 'platform', 'namespace' => 'Platform'], function () {
                // 平台清單
                Route::group(['prefix' => 'list'], function () {
                    Route::get('/', 'PlatformListController@index');
                    Route::get('/edit/{id}', 'PlatformListController@getEdit');
                    Route::put('/{id}', 'PlatformListController@edit');
                });

                //平台活動利率
                Route::group(['prefix' => 'activity'], function () {
                    Route::get('/', 'PlatformActivityController@index');
                    Route::get('/create', 'PlatformActivityController@getStore');
                    Route::get('/edit/{id}', 'PlatformActivityController@getEdit');
                    Route::post('/', 'PlatformActivityController@store');
                    Route::put('/{id}', 'PlatformActivityController@edit');
                    Route::put('/close/{id}', 'PlatformActivityController@close');
                    Route::delete('/{id}', 'PlatformActivityController@destroy');
                });
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
                Route::get('/interest/detail/{platformId}', 'ReportInterestController@detail');
            });

            // 系統管理
            Route::group(['prefix' => 'system', 'namespace' => 'System'], function () {
                // 角色管理
                Route::group(['prefix' => 'role'], function () {
                    Route::get('/', 'SystemRoleController@index');
                    Route::get('/create', 'SystemRoleController@getStore');
                    Route::get('/edit/{id}', 'SystemRoleController@getEdit');
                    Route::post('/', 'SystemRoleController@store');
                    Route::put('/{id}', 'SystemRoleController@edit');
                    Route::delete('/{id}', 'SystemRoleController@destroy');
                });

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
                Route::group(['prefix' => 'operation'], function () {
                    Route::get('/', 'SystemOperationController@index');
                    // 單筆 Log 資訊
                    Route::get('/detail/{funcKey}/{funcId}', 'SystemOperationController@detail');
                });
            });
        });
    });
});
