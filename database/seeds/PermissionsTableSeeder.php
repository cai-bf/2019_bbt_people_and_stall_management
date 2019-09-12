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
            7 => 
            array (
                'id' => 8,
                'name' => '删除用户',
                'guard_name' => 'api',
                'route' => 'users.delete',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '回收用户',
                'guard_name' => 'api',
                'route' => 'users.recycle',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '编辑用户',
                'guard_name' => 'api',
                'route' => 'users.update',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => '添加校历',
                'guard_name' => 'api',
                'route' => 'calendar.new',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => '更新校历',
                'guard_name' => 'api',
                'route' => 'calendar.update',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => '删除校历',
                'guard_name' => 'api',
                'route' => 'calendar.delete',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => '审核课表',
                'guard_name' => 'api',
                'route' => 'schedule.check',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => '审核课表列表',
                'guard_name' => 'api',
                'route' => 'schedule.uncheck',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => '新建摆摊',
                'guard_name' => 'api',
                'route' => 'stall.new',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => '删除摆摊',
                'guard_name' => 'api',
                'route' => 'stall.delete',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => '更新摆摊',
                'guard_name' => 'api',
                'route' => 'stall.update',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => '导出摆摊',
                'guard_name' => 'api',
                'route' => 'stall.export',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => '新建摆摊任务',
                'guard_name' => 'api',
                'route' => 'task.new',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => '删除摆摊任务',
                'guard_name' => 'api',
                'route' => 'task.delete',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => '摆摊任务签到',
                'guard_name' => 'api',
                'route' => 'task.check',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => '摆摊任务添加负责人',
                'guard_name' => 'api',
                'route' => 'task.add',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => '摆摊任务删除负责人',
                'guard_name' => 'api',
                'route' => 'task.delete_admin',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => '摆摊任务生成名单',
                'guard_name' => 'api',
                'route' => 'task.create',
            ),
        ));
        
        
    }
}