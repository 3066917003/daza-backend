<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');                 // 用户Id
            $table->string('platform');                 // 平台 ['wechat', 'weibo', 'qq']
            $table->string('unique_id');                // 用户唯一标识
            $table->string('access_token');             // 接口调用凭证
            $table->integer('expires_in');              // access_token接口调用凭证超时时间，单位（秒）
            $table->string('refresh_token');            // 用户刷新access_token
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
        Schema::drop('user_auths');
    }
}
