<?php

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionQuizMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_quiz_mappings', function (Blueprint $table) {
            $table->id();
            $table->integer('subscription_id')->index();
            $table->integer('course_id')->index();
            $table->integer('subject_id')->index();
            $table->integer('lesson_id')->nullable()->index();
            $table->integer('video_id')->nullable()->index();
            $table->integer('quiz_id')->index();
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
        Schema::dropIfExists('subscription_quiz_mappings');
    }
}
