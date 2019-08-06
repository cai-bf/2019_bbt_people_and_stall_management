<?php

use Illuminate\Database\Seeder;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('colleges')->insert([
            [
                'name' => '机械与汽车工程学院'
            ],
            [
                'name' => '建筑学院'
            ],
            [
                'name' => '土木与交通学院'
            ],
            [
                'name' => '电子与信息学院'
            ],
            [
                'name' => '材料科学与工程学院'
            ],
            [
                'name' => '化学与化工学院'
            ],
            [
                'name' => '轻工与食品学院'
            ],
            [
                'name' => '数学学院'
            ],
            [
                'name' => '经济与贸易学院'
            ],
            [
                'name' => '自动化科学与工程学院'
            ],
            [
                'name' => '计算机科学与工程学院'
            ],
            [
                'name' => '电力学院'
            ],
            [
                'name' => '生物科学与工程学院'
            ],
            [
                'name' => '环境科学与工程学院'
            ],
            [
                'name' => '软件学院'
            ],
            [
                'name' => '工商管理学院'
            ],
            [
                'name' => '公共管理学院'
            ],
            [
                'name' => '外国语学院'
            ],
            [
                'name' => '法学院'
            ],
            [
                'name' => '知识产权学院'
            ],
            [
                'name' => '新闻与传播学院'
            ],
            [
                'name' => '艺术学院'
            ],
            [
                'name' => '体育学院'
            ],
            [
                'name' => '设计学院'
            ],
            [
                'name' => '物理与光电学院'
            ],
        ]);
    }
}
