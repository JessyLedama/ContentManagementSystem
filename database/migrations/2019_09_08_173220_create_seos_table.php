<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('seos'))

            Schema::create('seos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('keywords');
                $table->string('description');
                $table->string('title');
                $table->unsignedInteger('seoable_id');
                $table->string('seoable_type');
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
        Schema::dropIfExists('seos');
    }
}
