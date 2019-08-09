<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '添加新用户',
                'guard_name' => 'api',
                'route' => 'users.store',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '添加部门',
                'guard_name' => 'api',
                'route' => 'departments.create',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '编辑部门',
                'guard_name' => 'api',
                'route' => 'departments.update',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '删除部门',
                'guard_name' => 'api',
                'route' => 'departments.delete',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '删除管理层',
                'guard_name' => 'api',
                'route' => 'groups.delete',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '添加管理层',
                'guard_name' => 'api',
                'route' => 'groups.create',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '修改管理层',
                'guard_name' => 'api',
                'route' => 'groups.update',
            ),
        ));
        
        
    }
}