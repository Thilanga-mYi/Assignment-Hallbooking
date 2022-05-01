<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('lecture_category_id');
            $table->integer('lecture_hall_id');
            $table->integer('lecture_type')->default(1);
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])->nullable();
            $table->date('conduct_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('student_capacity');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    // LECTURE TYPES: ------------------------------------------------------------
    // 1 => Day to Day Lecture
    // 2 => Special Lecture

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures');
    }
}
