<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->insert([
            [
                'name' => '超级管理员',
                'guard_name' => 'api'
            ],
            [
                'name' => '管理员',
                'guard_name' => 'api'
            ],
            [
                'name' => '常委',
                'guard_name' => 'api'
            ],
            [
                'name' => '部长',
                'guard_name' => 'api'
            ],
            [
                'name' => '主管',
                'guard_name' => 'api'
            ],
            [
                'name' => '干事',
                'guard_name' => 'api'
            ],
        ]);
    }
}
