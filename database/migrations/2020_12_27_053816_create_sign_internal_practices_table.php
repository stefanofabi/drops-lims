<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignInternalPracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_internal_practices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('internal_practice_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('sign_date')->useCurrent();	

            // Unique keys
            $table->unique(['internal_practice_id', 'user_id']);

            // Foreign keys
            $table->foreign('internal_practice_id')->references('id')->on('internal_practices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('sign_internal_practices');
    }
}
