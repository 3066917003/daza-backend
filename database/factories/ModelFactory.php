<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'username'       => $faker->userName,
        'image_url'      => $faker->imageUrl($width = 100, $height = 100),
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->name,
        'image_url'   => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->text($maxNbChars = 200),
    ];
});

$factory->define(App\Models\Topic::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->name,
        'image_url'   => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->text($maxNbChars = 200),
    ];
});

$factory->define(App\Models\Article::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->name,
        'content'       => $faker->text,
        'image_url' => $faker->imageUrl($width = 640, $height = 480),
        'published_at'  => $faker->dateTime(),
    ];
});

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'title'     => $faker->name,
        'content'   => $faker->text,
        'image_url' => $faker->imageUrl($width = 640, $height = 480),
        'city'      => $faker->city,
    ];
});

$factory->define(App\Models\Tweet::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->name,
        'image_url'   => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->text($maxNbChars = 200),
    ];
});
