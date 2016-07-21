<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleViewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_viewers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');                     // 用户Id
            $table->integer('article_id');                  // 文章Id
            $table->string('ip_address', 45)->nullable();   // IP地址
            $table->text('user_agent')->nullable();         // UserAgent
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
        Schema::drop('article_viewers');
    }
}
