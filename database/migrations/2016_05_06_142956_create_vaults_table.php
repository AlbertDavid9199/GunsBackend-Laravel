<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaults', function (Blueprint $table) {
            $table->increments('vault_id');
            $table->string('name', 512);
            $table->string('description', 4096);
            $table->integer('quantity');
            $table->string('sku', 45);
            $table->string('serial_number', 45);
            $table->string('product_model', 45);
            $table->string('barrel_length', 45);
            $table->string('capacity', 45);
            $table->string('firing_casing', 45);
            $table->string('frame_per_material', 225);
            $table->string('sights', 225);
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('stock_number', 512);
            $table->string('original_stock_number', 512);
            $table->integer('published');
            $table->timestamp('published_at');
            $table->integer('price');
            $table->integer('original_price');
            $table->timestamp('date');
            $table->string('brand', 45);
            $table->string('caliber', 45);
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
        Schema::drop('vaults');
    }
}
