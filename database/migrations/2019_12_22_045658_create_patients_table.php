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
            $table->string('identification_number')->nullable();
            $table->char('sex', 1)->nullable();
            $table->date('birth_date')->nullable();
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

            // For animals
            $table->string('owner')->nullable();

            // For industrials
            $table->string('business_name')->nullable();
            $table->string('tax_condition')->nullable();
            $table->date('start_activity')->nullable();

            // To differentiate the type of patient
           	$table->enum('type', ['animal', 'human', 'industrial']);

            // Foreign keys
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('restrict')->onUpdate('cascade');

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
