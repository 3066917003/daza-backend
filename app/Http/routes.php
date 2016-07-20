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
    // account
    Route::post('/account/register', 'AccountController@register');
    Route::post('/account/login', 'AccountController@login');
    Route::post('/account/logout', 'AccountController@logout');
    Route::get('/account/profile', 'AccountController@getProfile');
    Route::put('/account/profile', 'AccountController@updateProfile');
    Route::post('/account/password_reset', 'AccountController@passwordReset');
    Route::post('/account/password_modify', 'AccountController@passwordModify');
    // users
    Route::resource('/users', 'UserController');
    Route::post('/users/{user_id}/relationship', 'UserRelationshipController@store');
    // topics
    Route::resource('/topics', 'TopicController');
    Route::get('/topics/{topic_id}/articles', 'TopicController@articles');
    Route::get('/topics/{topic_id}/subscribers', 'TopicSubscriberController@subscribers');
    Route::post('/topics/{topic_id}/subscribe', 'TopicSubscriberController@subscribe');
    Route::post('/topics/{topic_id}/unsubscribe', 'TopicSubscriberController@unsubscribe');
    // articles
    Route::resource('/articles', 'ArticleController');
    Route::resource('/articles/{article_id}/likes', 'ArticleLikeController');
    Route::resource('/articles/{article_id}/comments', 'ArticleCommentController');
    Route::get('/articles/{article_id}/viewers', 'ArticleViewerController@index');
    // tweets
    Route::resource('/tweets', 'TweetController');
    Route::resource('/tweets/{tweet_id}/likes', 'TweetLikeController');
    Route::resource('/tweets/{tweet_id}/comments', 'TweetCommentController');
    // events
    Route::resource('/events', 'EventController');
    // tags
    Route::resource('/tags', 'TagController');
    // notifications
    Route::resource('/notifications', 'NotificationController');
    Route::post('/notifications/mark', 'NotificationController@mark');
    Route::resource('/assets', 'AssetController');
});
