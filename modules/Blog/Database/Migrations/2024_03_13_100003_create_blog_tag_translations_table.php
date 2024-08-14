<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTagTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tag_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('blog_tag_id')->unsigned();
            $table->string('locale');
            $table->string('name');

            $table->unique(['blog_tag_id', 'locale']);

            $table->foreign('blog_tag_id')
                ->references('id')
                ->on('blog_tags')
                ->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_tag_translations');
    }
}
