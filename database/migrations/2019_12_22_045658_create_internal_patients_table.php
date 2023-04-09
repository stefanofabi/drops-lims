<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('name');
            $table->string('last_name');
            $table->string('identification_number')->nullable();
            $table->enum('sex', ['F', 'M']);
            $table->date('birthdate')->nullable();

            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternative_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('alternative_email')->nullable();

            // Affiliate
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('affiliate_number')->nullable();
            $table->date('expiration_date')->nullable();
            $table->unsignedInteger('security_code')->nullable();

            // Foreign keys
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('set null')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_patients');
    }
}
