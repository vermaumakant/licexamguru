<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStudyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_study_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('country_name', 100)->nullable();
            $table->string('state_name', 100)->nullable();
            $table->string('city_name')->nullable();
            $table->string('university_name')->nullable();
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
        Schema::dropIfExists('user_study_details');
    }
}
