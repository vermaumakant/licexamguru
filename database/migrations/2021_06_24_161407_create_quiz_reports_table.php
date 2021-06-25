<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id')->index();
            $table->integer('user_id')->index();
            $table->string('status')->default('open');
            $table->integer('number_of_questions')->default(0);
            $table->integer('current_question_id')->nullable();
            $table->integer('current_question_no')->default(0);
            $table->integer('question_attempted')->default(0);
            $table->integer('time_in_sec')->default(60);
            $table->integer('time_done')->default(0);
            $table->integer('question_currect')->default(0);
            $table->text('details')->nullable();
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
        Schema::dropIfExists('quiz_reports');
    }
}
