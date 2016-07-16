<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');         // 用户Id
            $table->string('title');            // 标题
            $table->string('content');          // 内容
            $table->dateTime('start_at');       // 开始时间
            $table->dateTime('end_at');         // 结束时间
            $table->string('organizer');        // 主办方
            $table->string('organizer_link');   // 主办方链接
            $table->string('city');             // 城市
            $table->string('location');         // 位置
            $table->double('longitude', 7, 7);  // 经度
            $table->double('latitude', 7, 7);   // 纬度
            $table->integer('like_count');      // 喜欢数
            $table->integer('view_count');      // 阅读数
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
        Schema::drop('events');
    }
}
