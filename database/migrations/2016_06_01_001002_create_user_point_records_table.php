<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_point_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');             // 用户Id
            $table->integer('point');               // 当前积分值
            $table->string('used_type');            // 变化类型
            $table->integer('used_point');          // 变化积分值
            $table->string('used_target_type');     // 变化目标类型
            $table->integer('used_target_id');      // 变化目标Id
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
        Schema::drop('user_point_records');
    }
}
