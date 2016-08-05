<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCyclingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycling_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('calories')->default(0);
            $table->dateTime('start_time');
            $table->dateTime('finish_time')->nullable();
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cycling_sessions', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::drop('cycling_sessions');
    }
}
