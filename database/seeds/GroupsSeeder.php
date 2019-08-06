<?php

use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('groups')->insert([
            [
                'isAdmin' => 1,
                'isManager' => 1,
                'name' => '超级管理员',
                'intro' => ''
            ],
            [
                'isAdmin' => 1,
                'isManager' => 1,
                'name' => '管理员',
                'intro' => ''
            ],
            [
                'isAdmin' => 0,
                'isManager' => 1,
                'name' => '常委',
                'intro' => '这是百步梯的最高决策层和管理层，直接和学校的老师接触'
            ],
            [
                'isAdmin' => 0,
                'isManager' => 1,
                'name' => '部长',
                'intro' => ''
            ],
            [
                'isAdmin' => 0,
                'isManager' => 0,
                'name' => '主管',
                'intro' => ''
            ],
            [
                'isAdmin' => 0,
                'isManager' => 0,
                'name' => '干事',
                'intro' => ''
            ],
        ]);
    }
}
