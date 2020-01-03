<?php

use Illuminate\Database\Seeder;

use App\Entities\Platform\Platform;

class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => '350搶紅包', 'present' => 50, 'future' => 50],
        ];

        foreach ($data as $value) {
            $check = Platform::find($value['id']);
            if ($check == null) {
                Platform::create($value);
            } else {
                Platform::find($value['id'])->update($value);
            }
        }
    }
}
