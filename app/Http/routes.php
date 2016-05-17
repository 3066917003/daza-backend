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
    return redirect('/docs/api');
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/account/register', 'UserController@register');
    Route::post('/account/login', 'UserController@login');
    Route::post('/account/logout', 'UserController@logout');
    Route::get('/account/profile', 'UserController@getProfile');
    Route::put('/account/profile', 'UserController@updateProfile');
    Route::post('/account/password_reset', 'UserController@passwordReset');
    Route::post('/account/password_modify', 'UserController@passwordModify');
    Route::resource('/users', 'UserController');
    Route::post('/users/{user_id}/relationship', 'UserRelationshipController@store');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/tags', 'TagController');
    Route::resource('/groups', 'GroupController');
    Route::post('/groups/{group_id}/join', 'GroupController@join');
    Route::resource('/groups/{group_id}/members', 'GroupMemberController');
    Route::resource('/tweets', 'TweetController');
    Route::resource('/tweets/{tweet_id}/comments', 'CommentController');
    Route::resource('/posts', 'PostController');
    Route::resource('/posts/{post_id}/comments', 'CommentController');
    Route::resource('/articles', 'ArticleController');
    Route::resource('/articles/{article_id}/comments', 'CommentController');
    Route::resource('/events', 'EventController');
    Route::resource('/events/{event_id}/comments', 'CommentController');
    Route::resource('/orders', 'OrderController');
    Route::resource('/notifications', 'NotificationController');
    Route::post('/notifications/mark', 'NotificationController@mark');
    Route::resource('/assets', 'AssetController');
});
