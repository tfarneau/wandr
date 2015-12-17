<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckpointsrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkpoints_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->double('lat');
            $table->double('lng');
            $table->integer('time');
            $table->string('mode');
            $table->string('type');
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
        Schema::drop('checkpoints_requests');
    }
}
