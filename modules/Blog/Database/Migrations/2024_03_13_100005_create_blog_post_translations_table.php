<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBlogPostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('blog_post_id')->unsigned();
            $table->string('locale');
            $table->string('title');
            $table->longText('description');

            $table->unique(['blog_post_id', 'locale']);

            $table->foreign('blog_post_id')
                ->references('id')
                ->on('blog_posts')
                ->cascadeOnDelete();
        });

        DB::statement('ALTER TABLE blog_post_translations ADD FULLTEXT(title)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_post_translations');
    }
}
