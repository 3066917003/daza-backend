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
                'id'         => 1,
                'username'   => 'dazaio',
                'email'      => 'app@daza.io',
                'name'       => '「daza.io」',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,
                'username'   => 'lijy91' ,
                'email'      => 'lijy91@foxmail.com',
                'name'       => '痕迹',
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
            [
                'user_id'     => 1,
                'slug'        => 'help',
                'name'        => '帮助中心',
                'description' => '您可以在「daza.io」官方帮助中心找到各种提示和辅导手册，从中了解如何使用本产品以及其他常见问题的答案。',
            ],
        ];
        DB::table('topics')->insert($topics);
        $topics= [
            ['type' => 'feed', 'user_id' => 1, 'name' => 'iPc.me', 'source_format' => 'rss+xml', 'source_link' => 'http://feed.ipc.me'],
            ['type' => 'feed', 'user_id' => 1, 'name' => 'RubyChina', 'source_format' => 'rss+xml', 'source_link' => 'https://ruby-china.org/topics/feed'],
            ['type' => 'feed', 'user_id' => 1, 'name' => 'CNode', 'source_format' => 'rss+xml', 'source_link' => 'https://cnodejs.org/rss'],
            ['type' => 'feed', 'user_id' => 1, 'name' => 'V2EX', 'source_format' => 'rss+xml', 'source_link' => 'https://www.v2ex.com/index.xml'],
        ];
        DB::table('topics')->insert($topics);
        $tags = [
            ['name' => 'Android'],
            ['name' => 'iOS'],
            ['name' => 'macOS'],
            ['name' => 'Windows'],
            ['name' => 'Java'],
            ['name' => 'JavaScript'],
            ['name' => 'C++'],
            ['name' => 'Python'],
            ['name' => 'Ruby'],
            ['name' => 'Docker'],
        ];
        DB::table('tags')->insert($tags);
    }
}
