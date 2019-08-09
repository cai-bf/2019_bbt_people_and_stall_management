<?php

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_has_permissions')->delete();
        
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 1,
                'role_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 1,
                'role_id' => 2,
            ),
            2 => 
            array (
                'permission_id' => 1,
                'role_id' => 3,
            ),
            3 => 
            array (
                'permission_id' => 1,
                'role_id' => 4,
            ),
            4 => 
            array (
                'permission_id' => 2,
                'role_id' => 1,
            ),
            5 => 
            array (
                'permission_id' => 3,
                'role_id' => 1,
            ),
            6 => 
            array (
                'permission_id' => 4,
                'role_id' => 1,
            ),
            7 => 
            array (
                'permission_id' => 5,
                'role_id' => 1,
            ),
            8 => 
            array (
                'permission_id' => 6,
                'role_id' => 1,
            ),
            9 => 
            array (
                'permission_id' => 7,
                'role_id' => 1,
            ),
            10 => 
            array (
                'permission_id' => 8,
                'role_id' => 1,
            ),
            11 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            12 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            13 => 
            array (
                'permission_id' => 8,
                'role_id' => 4,
            ),
            14 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            15 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            16 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            17 => 
            array (
                'permission_id' => 9,
                'role_id' => 4,
            ),
            18 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            19 => 
            array (
                'permission_id' => 10,
                'role_id' => 2,
            ),
            20 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            21 => 
            array (
                'permission_id' => 10,
                'role_id' => 4,
            ),
        ));
        
        
    }
}