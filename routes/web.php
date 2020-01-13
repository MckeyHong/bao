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

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth:user']], function () {
        Route::get('/home', 'HomeController@index')->name('home');

        Route::group(['middleware' => 'permission'], function () {
            Route::group(['prefix' => 'platform', 'namespace' => 'Platform'], function () {
                Route::get('/list', 'PlatformListController@index');
                Route::get('/activity', 'PlatformActivityController@index');
            });

            Route::group(['prefix' => 'member', 'namespace' => 'Member'], function () {
                Route::get('/list', 'MemberListController@index');
                Route::get('/transfer', 'MemberTransferController@index');
                Route::get('/login', 'MemberLoginController@index');
            });

            Route::group(['prefix' => 'report', 'namespace' => 'Report'], function () {
                Route::get('/member', 'ReportMemberController@index');
                Route::get('/interest', 'ReportInterestController@index');
            });

            Route::group(['prefix' => 'system', 'namespace' => 'System'], function () {
                Route::get('/role', 'SystemRoleController@index');
                Route::get('/user', 'SystemUserController@index');
                Route::get('/login', 'SystemLoginController@index');
                Route::get('/operation', 'SystemOperationController@index');
            });
        });
    });
});
