<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');         // 用户Id
            $table->integer('topic_id');        // 主题Id
            $table->string('guid');             // 文章唯一标识符
            $table->string('type');             // 类型
            $table->string('link');             // 文章链接
            $table->string('title');            // 标题
            $table->string('summary');          // 摘要
            $table->text('content');            // 内容
            $table->string('image_url');        // 图片链接（原始尺寸）
            $table->string('audio_url');        // 音频网址
            $table->string('video_url');        // 视频网址
            $table->string('author');           // 作者
            $table->string('author_email');     // 作者邮箱
            $table->string('author_link');      // 作者链接
            $table->string('source');           // 来源
            $table->string('source_link');      // 来源链接
            $table->string('location');         // 位置
            $table->double('longitude', 7, 7);  // 经度
            $table->double('latitude', 7, 7);   // 纬度
            $table->integer('view_count');      // 阅读数
            $table->integer('like_count');      // 喜欢数
            $table->integer('comment_count');   // 评论数
            $table->dateTime('published_at');   // 发表时间
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
        Schema::drop('articles');
    }
}
