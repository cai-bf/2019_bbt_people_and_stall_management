<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            [
                'sno' => '201010101010',
                'password' => '$2y$10$h16N.bL3YqKRyXYyOOCvFO3xguM0ApMl4MozzTyA2kAgKUp2uoMq.',
                'group_id' => 1,
                'department_id' => 1
            ],
            [
                'sno' => '201730612383',
                'password' => '$2y$10$h16N.bL3YqKRyXYyOOCvFO3xguM0ApMl4MozzTyA2kAgKUp2uoMq.',
                'group_id' => 4,
                'department_id' => 1
            ]
        ]);
    }
}
