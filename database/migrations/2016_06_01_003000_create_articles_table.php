<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');         // 用户Id
            $table->integer('topic_id');        // 话题Id
            $table->string('type');             // 类型
            $table->string('author');           // 作者
            $table->string('author_link');      // 作者链接
            $table->string('source');           // 来源
            $table->string('source_link');      // 来源链接
            $table->string('title');            // 标题
            $table->string('summary');          // 摘要
            $table->string('content');          // 内容
            $table->integer('like_count');      // 喜欢数
            $table->integer('comment_count');   // 评论数
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
        Schema::drop('articles');
    }
}
