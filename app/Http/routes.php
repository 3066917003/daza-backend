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
    Route::post('/account/register', 'UserController@register');
    Route::post('/account/login', 'UserController@login');
    Route::post('/account/logout', 'UserController@logout');
    Route::post('/account/password_reset', 'UserController@passwordReset');
    Route::post('/account/password_modify', 'UserController@passwordModify');
    Route::resource('/users', 'UserController');
    Route::post('/users/{user_id}/relationship', 'UserRelationshipController@store');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/tags', 'TagController');
    Route::resource('/groups', 'GroupController');
    Route::resource('/tweets', 'TweetController');
    Route::resource('/posts', 'PostController');
    Route::resource('/articles', 'ArticleController');
    Route::resource('/events', 'EventController');
    Route::resource('/ordres', 'OrderController');
    Route::resource('/notifications', 'NotificationController');
});
