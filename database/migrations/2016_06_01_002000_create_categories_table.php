<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();              // 名称
            $table->string('slug', 191)->unique()->nullable();  // Slug
            $table->string('image_url');                        // 图片链接（原始尺寸）
            $table->string('description');                      // 描述
            $table->integer('topic_count');                     // 主题数
            $table->integer('article_count');                   // 文章数
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
        Schema::drop('categories');
    }
}
