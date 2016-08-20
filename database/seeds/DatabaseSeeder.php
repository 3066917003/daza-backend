<?php

use Carbon\Carbon;

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
        $users = [
            [
                'username'   => 'lijy91' ,
                'email'      => 'lijy91@foxmail.com',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username'   => 'daza_io',
                'email'      => 'app@daza.io',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username'   => 'robot_daza_io',
                'email'      => 'robot@daza.io',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('users')->insert($users);
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
        $topics = [
            ['type' => 'type', 'name' => 'iPc.me', 'source_format' => 'rss+xml', 'source_link' => 'http://feed.ipc.me'],
            ['type' => 'type', 'name' => 'RubyChina', 'source_format' => 'rss+xml', 'source_link' => 'https://ruby-china.org/topics/feed'],
            ['type' => 'type', 'name' => 'CNode', 'source_format' => 'rss+xml', 'source_link' => 'https://cnodejs.org/rss'],
        ];
        DB::table('topics')->insert($topics);
    }
}
