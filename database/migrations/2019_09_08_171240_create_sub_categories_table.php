<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subcategories'))

            Schema::create('subcategories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug');
                $table->string('cover')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('categoryId');
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
        Schema::dropIfExists('sub_categories');
    }
}
