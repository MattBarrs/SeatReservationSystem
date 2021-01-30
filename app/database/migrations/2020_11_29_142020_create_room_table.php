<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->string('room_name');
            $table->string('institution_name');
            $table->time('close_time');
            $table->time('open_time');
            $table->float('reference_length');
            $table->string('floor_plan');
            $table->json('room_details')->nullable();// change to details

            $table->timestamps();
            $table->index(['room_name','institution_name']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
