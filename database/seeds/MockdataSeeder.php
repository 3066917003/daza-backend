<?php

use App\Models\User;
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
        factory(User::class, 20)->create()->each(function($user) {
            $user->topics()->saveMany(factory(Topic::class, 10)->make());
            $user->articles()->saveMany(factory(Article::class, 10)->make());
            $user->tweets()->saveMany(factory(Tweet::class, 10)->make());
            $user->events()->saveMany(factory(Event::class, 10)->make());
        });
        factory(Category::class, 10)->create();
    }
}
