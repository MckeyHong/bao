<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Entities\User\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'account' => 'admin888', 'name' => '管理员', 'password' => Hash::make('asd123'), 'role_id' => 1],
        ];

        foreach ($data as $value) {
            $check = User::find($value['id']);
            if ($check == null) {
                User::create($value);
            } else {
                User::find($value['id'])->update($value);
            }
        }
    }
}
