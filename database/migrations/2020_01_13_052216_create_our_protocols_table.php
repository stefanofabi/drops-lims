<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_protocols', function (Blueprint $table) {
            $table->unsignedBigInteger('protocol_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('prescriber_id');
            $table->date('withdrawal_date')->nullable();
            $table->unsignedInteger('quantity_orders')->default(0);
            $table->string('diagnostic')->nullable();

            // Primary key
            $table->primary('protocol_id');

            // Foreign keys
            $table->foreign('protocol_id')->references('id')->on('protocols')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('prescriber_id')->references('id')->on('prescribers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('restrict')->onUpdate('cascade');


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
        Schema::dropIfExists('our_protocols');
    }
}
