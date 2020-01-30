<?php

namespace App\Http\Controllers\Auth;

use App;
use Redis;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\System\SystemLoginServices;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'ctl/home';
    protected $systemLoginSrv;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SystemLoginServices $systemLoginSrv
    ) {
        $this->middleware('guest')->except('logout');
        $this->systemLoginSrv = $systemLoginSrv;
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $ip = get_real_ip($request->ip());
        $request['active'] = 1;
        if ($this->guard()->attempt($request->only('account', 'password', 'active'))) {
            $user = Auth::user();
            $this->systemLoginSrv->store($ip, $user);
            // 設定單用戶
            $time = time();
            $singleToken = md5($ip . $user['id'] . $time);
            Redis::set('STRING_SINGLETOKEN_' . $user['id'], $time);
            Session::put('SINGLETOKEN', $singleToken);
            // 設定語系
            $locale = (in_array($request->input('locale'), ['en', 'zh-CN', 'zh-TW'])) ? $request->input('locale') : config('app.fallback_locale');
            Session::put('locale', $locale);
            return $this->sendLoginResponse($request);
        }
        $this->systemLoginSrv->store($ip, ['user_account' => $request->input('account', '')], 4);
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $this->guard()->logout();

        $request->session()->invalidate();
        Redis::set('STRING_SINGLETOKEN_' . $user['id'], '');
        $this->systemLoginSrv->store(get_real_ip($request->ip()), $user, 2);

        return $this->loggedOut($request) ?: redirect('/ctl/home');
    }

    public function username()
    {
        return 'account';
    }
}
