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
                'name'       => 'daza.io',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,
                'username'   => 'hidazaio',
                'email'      => 'hi@daza.io',
                'name'       => 'hi@daza.io',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,
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
            ['id' => 1, 'name' => '新闻', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => '后端', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => '前端', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => '移动端', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => '数据库', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => '设计', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => '产品', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => '博客', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'name' => '其他', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('categories')->insert($categories);
        $topics = [
            [
                'type'        => 'official',
                'user_id'     => 1,
                'slug'        => 'help',
                'name'        => '帮助中心',
                'description' => '您可以在「daza.io」官方帮助中心找到各种提示和辅导手册，从中了解如何使用本产品以及其他常见问题的答案。',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type'        => 'official',
                'user_id'     => 1,
                'slug'        => 'launch-screen',
                'name'        => '启动屏幕',
                'description' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type'        => 'official',
                'user_id'     => 1,
                'slug'        => 'update-log',
                'name'        => '更新日志',
                'description' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type'        => 'official',
                'user_id'     => 1,
                'slug'        => 'side-ad',
                'name'        => '置顶广告',
                'description' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'type'        => 'official',
                'user_id'     => 1,
                'slug'        => 'side-links',
                'name'        => '友情链接',
                'description' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('topics')->insert($topics);
        $topics= [
            [
                'type' => 'feed',
                'user_id' => 2,
                'name' => 'iPc.me',
                'source_format' => 'rss+xml',
                'source_link' => 'http://feed.ipc.me',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()],
            [
                'type' => 'feed',
                'user_id' => 2,
                'name' => 'RubyChina最新帖子',
                'source_format' => 'rss+xml',
                'source_link' => 'https://ruby-china.org/topics/feed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()],
            [
                'type' => 'feed',
                'user_id' => 2,
                'name' => 'CNode最新帖子',
                'source_format' => 'rss+xml',
                'source_link' => 'https://cnodejs.org/rss',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()],
            [
                'type' => 'feed',
                'user_id' => 2,
                'name' => 'V2EX最新帖子',
                'source_format' => 'rss+xml',
                'source_link' => 'https://www.v2ex.com/index.xml',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()],
        ];
        DB::table('topics')->insert($topics);
        $tags = [
            ['name' => 'Android', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'iOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'macOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Windows', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Java', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'JavaScript', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'C++', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Python', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ruby', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Docker', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('tags')->insert($tags);
    }
}
