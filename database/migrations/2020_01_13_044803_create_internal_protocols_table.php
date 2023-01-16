<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInternalProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_protocols', function (Blueprint $table) {
            $table->id();
            $table->date('completion_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('observations')->nullable();
            $table->string('private_notes')->nullable();
            $table->timestamp('closed')->nullable();
            
            $table->unsignedBigInteger('internal_patient_id');
            $table->unsignedBigInteger('prescriber_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('billing_period_id');
            $table->date('withdrawal_date')->nullable();
            $table->unsignedInteger('quantity_orders')->nullable();
            $table->string('diagnostic')->nullable();
            $table->unsignedDouble('total_price')->default(0.0);
            
            // Foreign keys
            $table->foreign('internal_patient_id')->references('id')->on('internal_patients')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('prescriber_id')->references('id')->on('prescribers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('billing_period_id')->references('id')->on('billing_periods')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        DB::statement('ALTER TABLE internal_protocols INHERIT protocols');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_protocols');
    }
}
