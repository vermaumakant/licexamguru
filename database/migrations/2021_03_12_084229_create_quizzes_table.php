<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id')->index();
            $table->integer('course_id')->index();
            $table->integer('subject_id')->index();
            $table->integer('lesson_id')->nullable()->index();
            $table->integer('video_id')->nullable()->index();
            $table->string('quiz_name', 100)->index();
            $table->string('description')->nullable();
            $table->string('quiz-icon')->nullable();
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
        Schema::dropIfExists('quizzes');
    }
}
