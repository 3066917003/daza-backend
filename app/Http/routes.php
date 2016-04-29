<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'v1'], function () {
    Route::resource('/users', 'UserController');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/tags', 'TagController');
    Route::resource('/groups', 'GroupController');
    Route::resource('/tweets', 'TweetController');
    Route::resource('/posts', 'PostController');
    Route::resource('/events', 'EventController');
    Route::resource('/messages', 'MessageController');
});
