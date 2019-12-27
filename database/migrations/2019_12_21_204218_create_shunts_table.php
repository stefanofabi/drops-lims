<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShuntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shunts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('mail')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();

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
        Schema::dropIfExists('shunts');
    }
}
