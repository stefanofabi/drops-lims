<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerivedProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derived_protocols', function (Blueprint $table) {
            $table->unsignedBigInteger('protocol_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('reference')->nullable();

            // Primary key
            $table->primary('protocol_id');

            // Foreign keys
            $table->foreign('protocol_id')->references('id')->on('protocols')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('derived_patients')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('derived_protocols');
    }
}
