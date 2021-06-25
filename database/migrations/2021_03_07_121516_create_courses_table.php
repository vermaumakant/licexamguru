<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id')->index();
            $table->integer('admin_id')->index();
            $table->string('course_name', 100)->index();
            $table->string('course_icon')->default('default/course.png');
            $table->string('description')->nullable();
            $table->string('course_status', 20)->default('active')->index();
            $table->integer('course_created_by')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
