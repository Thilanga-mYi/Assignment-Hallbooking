<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportHasRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_has_rides', function (Blueprint $table) {
            $table->id();
            $table->integer('transport_id');
            $table->integer('transport_type')->default(1);
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])->nullable();
            $table->date('transport_date')->nullable();
            $table->time('in_time');
            $table->time('out_time')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    // TRANSPORT TYPES: ------------------------------------------------------------------------------------------
    // 1 => Normal Transport
    // 2 => Special Transport

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transport_has_rides');
    }
}
