<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('provincial_enrollment')->unsigned()->nullable();
            $table->integer('national_enrollment')->unsigned()->nullable();

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
        Schema::dropIfExists('prescribers');
    }
}
