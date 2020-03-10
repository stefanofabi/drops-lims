<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerivedPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derived_patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->nullable();
            $table->string('full_name')->nullable();
            $table->char('sex', 1)->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('shunt_id');

            // Foreign keys
            $table->foreign('shunt_id')->references('id')->on('shunts')->onDelete('restrict')->onUpdate('cascade');


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
        Schema::dropIfExists('derived_patients');
    }
}
