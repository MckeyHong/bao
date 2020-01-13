<?php

namespace App\Http\Middleware;

use Auth;
use Cache;
use Closure;
use App\Repositories\Role\RolePermissionRepository;

class PermissionAuthenticated
{
    /**
     * 後台功能權限判斷機制
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('user')->user();
        $permission = Cache::tags(['adminPermission'])->get($user['id']);
        if ($permission == null) {
            $permission = [];
            $repo = new RolePermissionRepository();
            $tmp = $repo->getListByRoleId($user['role_id']);
            foreach ($tmp as $value) {
                $value = $value->toArray();
                $permission[$value['path']] = $value;
            }
            Cache::tags(['adminPermission'])->put($user['id'], $permission, 1440);
        }
        if (($permission[$request->path()]['is_' . strtolower($request->method())] ?? 2) != 1) {
            abort(403);
        }

        return $next($request);
    }
}
