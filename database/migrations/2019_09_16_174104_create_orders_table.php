<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('orders'))

            Schema::create('orders', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ordNo');
                $table->string('transactionNo');
                $table->string('status');
                $table->decimal('shippingCost');
                $table->decimal('total');
                $table->unsignedInteger('customerId');
                $table->unsignedInteger('addressId');
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
        Schema::dropIfExists('orders');
    }
}
