<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ga_service_id');
            $table->integer('slack_service_id');
            $table->integer('is_active')->default(1);
            $table->string('name');
            $table->text('whosee');
            $table->string('ga_account');
            $table->string('ga_property');
            $table->string('ga_profile');
            $table->string('slack_channel');
            $table->string('start_date');
            $table->string('end_date');
            $table->text('template');
            $table->integer('timezone')->default(0);
            $table->string('activation_hours');
            $table->string('activation_days');
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
        Schema::drop('generators');
    }
}
