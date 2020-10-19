<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reviews'))

            Schema::create('reviews', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('rating');
                $table->string('title');
                $table->string('name');
                $table->string('comment');
                $table->string('recommend');
                $table->unsignedInteger('productId');
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
        Schema::dropIfExists('reviews');
    }
}
