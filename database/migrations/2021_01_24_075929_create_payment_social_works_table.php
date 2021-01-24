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
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');
            $table->unsignedBigInteger('social_work_id');
            $table->double('amount')->default(0.0);

            // Foreign keys
            $table->foreign('social_work_id')->references('id')->on('social_works')->onDelete('restrict')->onUpdate('cascade');

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
