<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkpoints', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->string('fs_id')->nullable()->unique();
            $table->string('name')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->integer('checkin_count')->nullable();
            $table->string('photo_original')->nullable();
            $table->string('photo_saved')->nullable();
            $table->string('url')->nullable();
            $table->float('rating')->nullable();
            $table->string('address')->nullable();
            $table->text('tip')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('checkpoints');
    }
}
