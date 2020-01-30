<?php

namespace App\Http\Middleware;

use Closure;
use Redis;

class AuthenticateSession
{
    /**
     * 單用戶登入檢查
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string    $type
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        $sessionSignToken = session()->get('SINGLETOKEN');
        if (!$sessionSignToken) {
            auth()->guard($type)->user()->logout();
            return redirect('/ctl/login');
        }

        // 得到redis中的key
        $user = auth()->guard($type)->user();
        $key = 'STRING_SINGLETOKEN_' . $user['id'];
        if (Redis::exists($key)) {
            // 取得登入時的時間戳
            $signTime = Redis::get($key);
            $signToken = md5(get_real_ip(request()->getClientIp()) . $user['id'] . Redis::get($key));
            if ($signToken !== $sessionSignToken) {
                auth()->guard($type)->logout();
                return redirect('/ctl/login');
            }
            return $next($request);
        } else {
            auth()->guard($type)->logout();
            return redirect('/ctl/login');
        }
    }
}
