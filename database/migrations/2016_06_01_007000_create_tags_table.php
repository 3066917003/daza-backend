<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();              // 名称
            $table->string('slug', 191)->unique()->nullable();  // Slug
            $table->string('standard_name');                    // 标准名称
            $table->string('image_url');                        // 图片链接（原始尺寸）
            $table->string('description');                      // 描述
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
        Schema::drop('tags');
    }
}
