<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
    public function __construct(SystemLoginServices $systemLoginSrv)
    {
        $this->systemLoginSrv = $systemLoginSrv;
        $this->middleware('guest')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $ip = get_real_ip($request->ip());
        if ($this->attemptLogin($request)) {
            $this->systemLoginSrv->store($ip, Auth::user());
            return $this->sendLoginResponse($request);
        }

        $this->systemLoginSrv->store($ip, $request->all(), 2);


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
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/ctl/home');
    }

    public function username()
    {
        return 'account';
    }
}
