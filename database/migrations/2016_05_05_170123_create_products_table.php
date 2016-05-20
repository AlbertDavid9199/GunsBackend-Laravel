<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->integer('manufacture_id');
            $table->string('name', 512);
            $table->string('description', 4096);
            $table->string('sku', 45);
            $table->string('serial_number', 45);
            $table->string('product_model', 45);
            $table->string('barrel_length', 45);
            $table->string('capacity', 45);
            $table->string('firing_casing', 45);
            $table->string('frame_per_material', 225);
            $table->string('sights', 225);
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
        Schema::drop('products');
    }
}
