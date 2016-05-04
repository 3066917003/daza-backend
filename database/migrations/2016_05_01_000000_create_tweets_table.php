<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');         // 用户Id
            $table->string('content');          // 内容
            $table->string('location');         // 位置
            $table->double('longitude', 7, 7);  // 经度
            $table->double('latitude', 7, 7);   // 纬度
            $table->string('source');           // 来源
            $table->string('source_link');      // 来源链接
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
        Schema::drop('tweets');
    }
}
