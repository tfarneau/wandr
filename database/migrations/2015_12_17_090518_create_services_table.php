<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('slug');
            $table->string('status');
            $table->text('var1')->nullable();
            $table->text('var2')->nullable();
            $table->text('var3')->nullable();
            $table->text('var4')->nullable();
            $table->text('var5')->nullable();
            $table->text('var6')->nullable();
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
        Schema::drop('services');
    }
}
