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

        $tmp = explode('/', $request->path());
        if (count($tmp) > 3) { // 內頁
            $path = $tmp[0] . '/' . $tmp[1] . '/' . $tmp[2];
            switch ($tmp[3]) {
                case 'create':
                    $method = 'is_post';
                    break;
                case 'edit':
                    $method = 'is_put';
                    break;
                default:
                    $method = '';
            }
        } else {
            $path = $request->path();
            $method = 'is_' . strtolower($request->method());
        }
        if (($permission[$path][$method] ?? 2) != 1) {
            abort(403);
        }

        return $next($request);
    }
}
