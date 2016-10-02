<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');                 // 用户Id
            $table->boolean('unread')->default(true);   // 通知未读
            $table->string('reason');                   // 原因
            $table->integer('from_user_id');            // 来自用户Id
            $table->integer('topic_id');                // 主题Id
            $table->integer('article_id');              // 文章Id
            $table->integer('article_comment_id');      // 文章评论Id
            $table->string('title');                    // 标题
            $table->string('content');                  // 内容
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
        Schema::drop('notifications');
    }
}
