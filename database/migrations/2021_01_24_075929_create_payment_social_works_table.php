<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSocialWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_social_works', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->unsignedBigInteger('social_work_id');
            $table->unsignedBigInteger('billing_period_id');
            $table->double('amount');

            // Foreign keys
            $table->foreign('social_work_id')->references('id')->on('social_works')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('billing_period_id')->references('id')->on('billing_periods')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_social_works');
    }
}
