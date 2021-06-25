<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id')->index();
            $table->integer('course_id')->index();
            $table->integer('subject_id')->index();
            $table->integer('lesson_id')->nullable()->index();
            $table->integer('teacher_id')->nullable()->index();
            $table->string('video_title');
            $table->string('video_thumb')->nullable();
            $table->string('video')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('videos');
    }
}
