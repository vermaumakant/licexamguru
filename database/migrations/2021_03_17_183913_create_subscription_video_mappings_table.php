<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionVideoMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_video_mappings', function (Blueprint $table) {
            $table->id();
            $table->integer('subscription_id')->index();
            $table->integer('course_id')->index();
            $table->integer('subject_id')->index();
            $table->integer('lesson_id')->nullable()->index();
            $table->integer('video_id')->index();
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
        Schema::dropIfExists('subscription_video_mappings');
    }
}
