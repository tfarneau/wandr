<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landuses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('key');
            $table->string('value');
            $table->string('name')->nullable();
            $table->float('lat');
            $table->float('lng');
            $table->integer('surface');
            $table->string('source_type');
            $table->string('source_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('landuses');
    }
}
