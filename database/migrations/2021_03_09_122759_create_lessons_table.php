<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id')->index();
            $table->integer('course_id')->index();
            $table->integer('subject_id')->index();
            $table->integer('teacher_id')->index();
            $table->string('lesson_name');
            $table->text('description')->nullable();
            $table->string('lesson_icon')->nullable();
            $table->string('lesson_type')->default('video');
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
