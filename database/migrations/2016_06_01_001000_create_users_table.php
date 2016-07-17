<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 191)->unique()->nullable();  // 用户名
            $table->string('email', 191)->unique()->nullable();     // 邮箱
            $table->string('mobile', 191)->unique()->nullable();    // 手机
            $table->string('password');                             // 密码
            $table->string('name'), 191)->unique()->nullable();     // 名称
            $table->string('first_name');                           // 名
            $table->string('last_name');                            // 姓
            $table->string('avatar_url');                           // 头像
            $table->integer('age');                                 // 年龄
            $table->string('gender')->default('unspecified');       // 性别 [unspecified, secrecy, male, female]
            $table->string('birthday');                             // 生日
            $table->string('country');                              // 国家
            $table->string('city');                                 // 城市
            $table->string('address');                              // 地址
            $table->string('phone');                                // 电话
            $table->string('company');                              // 公司
            $table->string('website');                              // 主页
            $table->string('bio');                                  // 简介
            $table->integer('status')->default(1);                  // 状态[ 0 => 'Unactive', 1 => 'Active']
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
