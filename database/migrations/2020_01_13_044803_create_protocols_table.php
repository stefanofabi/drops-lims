<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->id();
            $table->date('completion_date')->nullable();
            $table->string('observations')->nullable();
            $table->timestamp('closed')->nullable();
            $table->enum('type', ['our', 'derived']);

            /*  ------- Our protocols -------   */
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('prescriber_id')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->unsignedInteger('quantity_orders')->default(0);
            $table->string('diagnostic')->nullable();
            $table->unsignedBigInteger('billing_period_id')->nullable();

            // Foreign keys
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('prescriber_id')->references('id')->on('prescribers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('billing_period_id')->references('id')->on('billing_periods')->onDelete('restrict')->onUpdate('cascade');

            /*  ------- Derived protocols -------   */
            $table->unsignedBigInteger('derived_patient_id')->nullable();
            $table->string('reference')->nullable();

            // Foreign keys
            $table->foreign('derived_patient_id')->references('id')->on('derived_patients')->onDelete('restrict')->onUpdate('cascade');


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
        Schema::dropIfExists('protocols');
    }
}
