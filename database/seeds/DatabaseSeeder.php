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
        $categories = [
            ['id' => 1, 'name' => '新闻'],
            ['id' => 2, 'name' => '后端'],
            ['id' => 3, 'name' => '前端'],
            ['id' => 4, 'name' => '移动端'],
            ['id' => 5, 'name' => '数据库'],
            ['id' => 6, 'name' => '设计'],
            ['id' => 7, 'name' => '产品'],
            ['id' => 8, 'name' => '博客'],
        ];
        DB::table('categories')->insert($categories);
    }
}
