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
            $table->string('name', 191)->unique()->nullable();      // 名称
            $table->string('first_name');                           // 名
            $table->string('last_name');                            // 姓
            $table->string('real_name');                            // 真实姓名
            $table->string('avatar_url');                           // 头像链接（原始尺寸）
            $table->boolean('use_gravatar')->default(false);        // 使用Gravatar头像
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
            $table->boolean('site_admin')->default(false);          // 站点管理员
            $table->integer('followers_count');                     // 粉丝数
            $table->integer('following_count');                     // 关注数
            $table->integer('topic_count');                         // 主题数
            $table->integer('article_count');                       // 文章数
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
