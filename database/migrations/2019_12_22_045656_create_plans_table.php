<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->double('nbu_price', 8, 2)->unsigned();
            $table->unsignedBigInteger('social_work_id');
            $table->unsignedBigInteger('nomenclator_id');

            // Foreign keys
            $table->foreign('social_work_id')->references('id')->on('social_works')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nomenclator_id')->references('id')->on('nomenclators')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('plans');
    }
}
