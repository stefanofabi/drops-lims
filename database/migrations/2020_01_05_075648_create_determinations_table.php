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
        	$table->bigInteger('nomenclator_id')->unsigned();
            $table->bigInteger('code')->unsigned();
            $table->string('name')->nullable();
            $table->integer('position')->unsigned();
            $table->double('biochemical_unit', 8, 2)->unsigned();
            
            // Foreign keys
            $table->foreign('nomenclator_id')->references('id')->on('nomenclators')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('determinations');
    }
}
