<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Group;
use App\Models\Tweet;
use App\Models\Post;
use App\Models\Article;
use App\Models\Event;
use App\Models\Order;

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
        factory(User::class, 50)->create()->each(function($user) {
            $user->tweets()->save(factory(Tweet::class)->make());
            $user->posts()->save(factory(Post::class)->make());
            $user->articles()->save(factory(Article::class)->make());
        });
        factory(Category::class, 30)->create();
        factory(Tag::class, 30)->create();
        factory(Group::class, 30)->create();
    }
}
