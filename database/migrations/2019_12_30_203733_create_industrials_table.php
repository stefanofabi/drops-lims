<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industrials', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_id');
            $table->string('business_name')->nullable();
            $table->string('cuit')->nullable();
            $table->string('tax_condition')->nullable();
            $table->date('start_activity')->nullable();
            $table->string('fiscal_address')->nullable();
            $table->string('city')->nullable();

            // Foreign keys
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('industrials');
    }
}
