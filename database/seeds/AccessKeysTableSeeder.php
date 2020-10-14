<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessKeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'student_code' => '74430',
            'name' => 'あかさかたこす',
            'class' => '74',
            'access_password' => 'medamawa',
        ];
        DB::table('access_keys')->insert($param);
    }
}
