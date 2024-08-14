<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationValueTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('variation_value_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variation_value_id')->unsigned();
            $table->string('locale');
            $table->string('label');

            $table->unique(['variation_value_id', 'locale']);
            $table->foreign('variation_value_id')->references('id')->on('variation_values')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_value_translations');
    }
}
