<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalPracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_practices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('internal_protocol_id');
            $table->unsignedBigInteger('determination_id');
            $table->json('result')->nullable();

            // it is redundant so as not to process the template each time a protocol is printed and also to make it independent of the default template of the determination
            $table->string('result_template', 15000)->nullable();
            
            $table->double('price');

            // Foreign keys
            $table->foreign('internal_protocol_id')->references('id')->on('internal_protocols')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('determination_id')->references('id')->on('determinations')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('internal_practices');
    }
}
