<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkstationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workstations', function (Blueprint $table) {
            $table->id();
            $table->string('roomID');
            $table->string('seatID');
            $table->json('availableExtra')->nullable();
            $table->float('coord_x');
            $table->float('coord_y');
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
        Schema::dropIfExists('workstations');
    }
}
