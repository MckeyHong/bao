<?php

namespace App\Services\Admin\System;

use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Admin\System\SystemLoginServices;
use App\Repositories\User\UserRepository;

class SystemProfileServices
{
    protected $systemLoginSrv;
    protected $userRepo;

    public function __construct(
        UserRepository $userRepo,
        SystemLoginServices $systemLoginSrv
    ) {
        $this->systemLoginSrv = $systemLoginSrv;
        $this->userRepo       = $userRepo;
    }

    /**
     * 取得個人資訊
     *
     * @return array
     */
    public function index()
    {
        try {
            return [
                'result' => true,
                'data'   => Auth::user(),
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 編輯
     *
     * @param  Request  $request
     * @return array
     */
    public function edit($request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $user = Auth::user();
                $this->userRepo->update($user->id, ['password' => Hash::make($request['password'])]);
                // 自動登出
                Auth::logout();
                $request->session()->invalidate();
                $this->systemLoginSrv->store(get_real_ip($request->ip()), $user, 3);
                return true;
            });
            return ['result' => $result];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }


    /**
     * 檢查目前密碼是否正確
     *
     * @param  string   $oldPassword
     * @return boolean
     */
    public function checkOldPasswordExists($oldPassword)
    {
        try {
            $user = Auth::user();
            return (Hash::check($oldPassword, $user->password)) ?: false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
