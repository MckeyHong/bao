<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $path = explode('/', $request->path())[0] ?? '';
        if ($path == 'ctl') {
            if (!$request->expectsJson()) {
                route('login');
            }
        } else {
            if (!$request->expectsJson()) {
                abort(401);
            }
        }
    }
}
