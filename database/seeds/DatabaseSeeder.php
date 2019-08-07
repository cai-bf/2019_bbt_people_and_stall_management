<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(DetailsSeeder::class);
        $this->call(CollegesSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
    }
}
