<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('post_id')->autoIncrement();
            $table->string('post_title')->nullable();
            $table->string('post_slug')->unique()->nullable();
            $table->mediumText('post_meta_description')->nullable();
            $table->mediumText('post_preview_text')->nullable();
            $table->longText('post_content')->nullable();
            $table->string('post_focus_keyword')->nullable();
            $table->mediumText('post_featured_image')->nullable();
            $table->integer('post_author')->nullable()->default(0);
            $table->timestamp('post_created')->useCurrent();
            $table->dateTime('post_last_updated')->nullable();
            $table->integer('post_status')->default(1);
            $table->longText('guid')->nullable();
            $table->integer('post_category')->default(0);
            $table->tinyInteger('index_on_search_engines')->default(1);
            $table->tinyInteger('follow_links')->default(1);
            $table->integer('views')->default(0);
            $table->tinyInteger('featured')->nullable()->default(0);
            $table->mediumText('post_banner_image')->nullable();
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('posts');
    }
}
