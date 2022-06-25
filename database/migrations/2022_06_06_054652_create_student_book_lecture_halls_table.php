<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentBookLectureHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_book_lecture_halls', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('lecture_hall_id');
            $table->string('reason');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('student_book_lecture_halls');
    }
}
