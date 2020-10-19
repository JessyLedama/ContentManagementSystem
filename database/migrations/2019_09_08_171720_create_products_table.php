<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products'))
        
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug');
                $table->decimal('regular_price')->nullable();
                $table->decimal('price');
                $table->boolean('featured')->default(false);
                $table->string('cover')->nullable();
                $table->string('gallery')->nullable();
                $table->text('description')->nullable();
                $table->text('shortDescription')->nullable();
                $table->unsignedInteger('subcategoryId')->nullable();
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
        Schema::dropIfExists('products');
    }
}
