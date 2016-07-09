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
            $table->string('type');                 // 类型
            $table->string('source_program');       // 来源程序
            $table->string('source_link');          // 来源链接
            $table->string('name', 191)->unique();  // 名称
            $table->string('image_url');            // 图片网址
            $table->string('description');          // 描述
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
