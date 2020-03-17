<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('protocol_id');
            $table->unsignedBigInteger('report_id');
            $table->double('amount')->default(0.0);

            // Foreign keys
            $table->foreign('protocol_id')->references('id')->on('protocols')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('restrict')->onUpdate('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('practices');
    }
}
