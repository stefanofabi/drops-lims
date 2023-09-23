<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeterminationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('determinations', function (Blueprint $table) {
        	$table->bigIncrements('id');
        	$table->unsignedBigInteger('nomenclator_id');
            $table->bigInteger('code')->unsigned();
            $table->string('name');
            $table->integer('position')->unsigned();
            $table->double('biochemical_unit', 8, 2)->unsigned();

            $table->string('javascript', "5000")->nullable();
            $table->string('template', "15000")->nullable();
            $table->json('template_variables')->nullable();

            $table->string('worksheet_template', "15000")->nullable();
            
            // Foreign keys
            $table->foreign('nomenclator_id')->references('id')->on('nomenclators')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('determinations');
    }
}
