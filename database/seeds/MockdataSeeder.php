<?php

use App\Models\User;
use App\Models\UserRelationship;
use App\Models\Category;
use App\Models\Topic;
use App\Models\Article;
use App\Models\Event;
use App\Models\Tweet;
use App\Models\Tag;

use Illuminate\Database\Seeder;

class MockdataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => '痕迹',
            'username'  => 'lijy91',
            'email'     => 'lijy91@foxmail.com',
            'password'  => bcrypt('123456'),
        ]);
        factory(User::class, 20)->create()->each(function($user) {
            UserRelationship::create([
                'user_id'        => 1,
                'target_user_id' => $user->id
            ]);
            UserRelationship::create([
                'user_id'        => $user->id,
                'target_user_id' => 1
            ]);
            $user->topics()->saveMany(factory(Topic::class, 10)->make());
            $user->articles()->saveMany(factory(Article::class, 10)->make());
            $user->tweets()->saveMany(factory(Tweet::class, 10)->make());
            $user->events()->saveMany(factory(Event::class, 10)->make());
        });
        factory(Category::class, 10)->create();
    }
}
