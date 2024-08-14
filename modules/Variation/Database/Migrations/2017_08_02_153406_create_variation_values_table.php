<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->unique();
            $table->integer('variation_id')->unsigned()->index();
            $table->string('value')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variation_values');
    }
}
