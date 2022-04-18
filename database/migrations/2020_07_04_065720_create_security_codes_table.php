<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internal_patient_id');
            $table->string('security_code');
            $table->date('expiration_date');
            $table->timestamp('used_at')->nullable();

            // Unique keys
            $table->unique(['internal_patient_id']);

            // Foreign keys
            $table->foreign('internal_patient_id')->references('id')->on('internal_patients')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('security_codes');
    }
}
