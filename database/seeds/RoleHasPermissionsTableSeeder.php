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
            22 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            23 => 
            array (
                'permission_id' => 11,
                'role_id' => 2,
            ),
            24 => 
            array (
                'permission_id' => 11,
                'role_id' => 3,
            ),
            25 => 
            array (
                'permission_id' => 11,
                'role_id' => 4,
            ),
            26 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            27 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            28 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            29 => 
            array (
                'permission_id' => 12,
                'role_id' => 4,
            ),
            30 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            31 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            32 => 
            array (
                'permission_id' => 13,
                'role_id' => 3,
            ),
            33 => 
            array (
                'permission_id' => 13,
                'role_id' => 4,
            ),
            34 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            35 => 
            array (
                'permission_id' => 14,
                'role_id' => 2,
            ),
            36 => 
            array (
                'permission_id' => 14,
                'role_id' => 3,
            ),
            37 => 
            array (
                'permission_id' => 14,
                'role_id' => 4,
            ),
            38 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            39 => 
            array (
                'permission_id' => 15,
                'role_id' => 2,
            ),
            40 => 
            array (
                'permission_id' => 15,
                'role_id' => 3,
            ),
            41 => 
            array (
                'permission_id' => 15,
                'role_id' => 4,
            ),
            42 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            43 => 
            array (
                'permission_id' => 16,
                'role_id' => 2,
            ),
            44 => 
            array (
                'permission_id' => 16,
                'role_id' => 3,
            ),
            45 => 
            array (
                'permission_id' => 16,
                'role_id' => 4,
            ),
            46 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
            47 => 
            array (
                'permission_id' => 17,
                'role_id' => 2,
            ),
            48 => 
            array (
                'permission_id' => 17,
                'role_id' => 3,
            ),
            49 => 
            array (
                'permission_id' => 17,
                'role_id' => 4,
            ),
            50 => 
            array (
                'permission_id' => 18,
                'role_id' => 1,
            ),
            51 => 
            array (
                'permission_id' => 18,
                'role_id' => 2,
            ),
            52 => 
            array (
                'permission_id' => 18,
                'role_id' => 3,
            ),
            53 => 
            array (
                'permission_id' => 18,
                'role_id' => 4,
            ),
            54 => 
            array (
                'permission_id' => 19,
                'role_id' => 1,
            ),
            55 => 
            array (
                'permission_id' => 19,
                'role_id' => 2,
            ),
            56 => 
            array (
                'permission_id' => 19,
                'role_id' => 3,
            ),
            57 => 
            array (
                'permission_id' => 19,
                'role_id' => 4,
            ),
            58 => 
            array (
                'permission_id' => 20,
                'role_id' => 1,
            ),
            59 => 
            array (
                'permission_id' => 20,
                'role_id' => 2,
            ),
            60 => 
            array (
                'permission_id' => 20,
                'role_id' => 3,
            ),
            61 => 
            array (
                'permission_id' => 20,
                'role_id' => 4,
            ),
            62 => 
            array (
                'permission_id' => 21,
                'role_id' => 1,
            ),
            63 => 
            array (
                'permission_id' => 21,
                'role_id' => 2,
            ),
            64 => 
            array (
                'permission_id' => 21,
                'role_id' => 3,
            ),
            65 => 
            array (
                'permission_id' => 21,
                'role_id' => 4,
            ),
            66 => 
            array (
                'permission_id' => 22,
                'role_id' => 1,
            ),
            67 => 
            array (
                'permission_id' => 22,
                'role_id' => 2,
            ),
            68 => 
            array (
                'permission_id' => 22,
                'role_id' => 3,
            ),
            69 => 
            array (
                'permission_id' => 22,
                'role_id' => 4,
            ),
            70 => 
            array (
                'permission_id' => 23,
                'role_id' => 1,
            ),
            71 => 
            array (
                'permission_id' => 23,
                'role_id' => 2,
            ),
            72 => 
            array (
                'permission_id' => 23,
                'role_id' => 3,
            ),
            73 => 
            array (
                'permission_id' => 23,
                'role_id' => 4,
            ),
            74 => 
            array (
                'permission_id' => 24,
                'role_id' => 1,
            ),
            75 => 
            array (
                'permission_id' => 24,
                'role_id' => 2,
            ),
            76 => 
            array (
                'permission_id' => 24,
                'role_id' => 3,
            ),
            77 => 
            array (
                'permission_id' => 24,
                'role_id' => 4,
            ),
            78 => 
            array (
                'permission_id' => 25,
                'role_id' => 1,
            ),
            79 => 
            array (
                'permission_id' => 25,
                'role_id' => 2,
            ),
            80 => 
            array (
                'permission_id' => 25,
                'role_id' => 3,
            ),
            81 => 
            array (
                'permission_id' => 25,
                'role_id' => 4,
            ),
        ));
        
        
    }
}