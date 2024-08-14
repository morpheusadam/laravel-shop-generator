<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductVariationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_variation_values', function (Blueprint $table) {
            $table->integer('order_product_variation_id')->unsigned();
            $table->integer('variation_value_id')->unsigned();

            $table->primary(['order_product_variation_id', 'variation_value_id'], 'order_product_variation_id_variation_value_id_primary');

            $table->foreign('order_product_variation_id', 'order_product_variation_values_order_product_variation_id')->references('id')->on('order_product_variations')->onDelete('cascade');
            $table->foreign('variation_value_id')->references('id')->on('variation_values')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_variation_values');
    }
}
