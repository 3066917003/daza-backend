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
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image_url' => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->text($maxNbChars = 200),
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image_url' => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->text($maxNbChars = 200),
    ];
});

$factory->define(App\Models\Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'image_url' => $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->text($maxNbChars = 200),
    ];
});

$factory->define(App\Models\Tweet::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->text,
    ];
});

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->text,
    ];
});
