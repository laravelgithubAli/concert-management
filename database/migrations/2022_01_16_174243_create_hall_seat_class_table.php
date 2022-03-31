<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallSeatClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hall_seat_class', function (Blueprint $table) {
            $table->foreignId('hall_id')->constrained();
            $table->foreignId('seat_class_id')->constrained();
            $table->integer('seat_count')->default(0);
            $table->integer('unit_cost');

            $table->unique(['hall_id','seat_class_id'],'hall_seat_class_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hall_seat_class');
    }
}
