<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');             // 用户Id
            $table->integer('category_id');         // 分类Id
            $table->string('type');                 // 类型[feed,official,original]
            $table->string('name', 191)->unique();  // 名称
            $table->string('website');              // 主页
            $table->string('image_url');            // 图片网址
            $table->string('description');          // 描述
            $table->string('source_format');        // 文章来源格式
            $table->string('source_link');          // 文章来源链接
            $table->integer('article_count');       // 文章数
            $table->integer('subscriber_count');    // 订阅数
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
        Schema::drop('topics');
    }
}
