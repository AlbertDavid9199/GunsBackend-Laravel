<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('state_id');
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('email', 225)->unique();
            $table->string('password', 225);
            $table->string('activated', 60);
            $table->string('phone', 60);
            $table->string('birthday', 45);
            $table->string('lisence', 45);
            $table->string('class', 45);
            $table->string('expires', 45);
            $table->string('role', 45);
            $table->integer('dealer');
            $table->string('dealer_license_number', 45);
            $table->string('dealer_license_upload', 512);
            $table->string('image_url', 225);
            $table->rememberToken();
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
        Schema::drop('user');
    }
}
