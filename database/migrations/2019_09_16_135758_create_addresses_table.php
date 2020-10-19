<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('addresses'))
        
            Schema::create('addresses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('phone');
                $table->string('county');
                $table->string('town');
                $table->string('street');
                $table->unsignedInteger('customerId');
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
        Schema::dropIfExists('addresses');
    }
}
