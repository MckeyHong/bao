<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = Request::path();
        View::share('path', $path);

        $tmp = trans('custom.web.func.' . $path);
        View::share('browserTitle', ($tmp != '') ? $tmp . ' - ' : '');
    }
}
