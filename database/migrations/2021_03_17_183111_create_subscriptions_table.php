<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id')->index();
            $table->string('subscription_name');
            $table->string('subscription_description');
            $table->decimal('subscription_amount', 20, 2)->default(0);
            $table->string('subscription_duration')->nullable();
            $table->integer('subscription_days');
            $table->integer('subscription_count')->default(0);
            $table->integer('subscription_step')->default(0);
            $table->string('status')->default('draft');
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
        Schema::dropIfExists('subscriptions');
    }
}
