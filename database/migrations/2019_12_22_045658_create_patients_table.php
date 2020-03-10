<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('key')->nullable();
            $table->char('sex', 1)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            // for animals
            $table->string('owner')->nullable();

            // for industrials
            $table->string('business_name')->nullable();
            $table->string('tax_condition')->nullable();
            $table->date('start_activity')->nullable();
            
            // to differentiate the type of patient
           	$table->string('type')->nullable();

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
        Schema::dropIfExists('patients');
    }
}
