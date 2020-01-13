<?php

use Illuminate\Database\Seeder;

use App\Entities\Role\Role;
use App\Entities\Role\RolePermission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => '网站管理员', 'active' => 1],
        ];

        foreach ($data as $value) {
            $check = Role::find($value['id']);
            if ($check == null) {
                Role::create($value);
            } else {
                Role::find($value['id'])->update($value);
            }

            foreach (config('permission.func') as $cate) {
                foreach ($cate['menu'] as $menu) {
                    $check = RolePermission::select('id')->where('role_id', $value['id'])->where('path', $menu['path'])->first();
                    if ($check == null) {
                        RolePermission::create([
                            'role_id' => $value['id'],
                            'path'    => $menu['path'],
                        ]);
                    } else {
                        Role::find($check['id'])->update([
                            'is_get'    => 1,
                            'is_post'   => 1,
                            'is_put'    => 1,
                            'is_delete' => 1,
                        ]);
                    }
                }
            }
        }
    }
}
