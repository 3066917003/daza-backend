<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweet_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');     // 用户Id
            $table->integer('tweet_id');    // 推文Id
            $table->text('content');        // 内容
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tweet_comments');
    }
}
