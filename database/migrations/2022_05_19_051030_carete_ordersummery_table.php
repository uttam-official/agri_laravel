<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CareteOrdersummeryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordersummery', function (Blueprint $table) {
            $table->id()->from(1000001);
            $table->bigInteger('customer_id');
            $table->bigInteger('billing_id');
            $table->bigInteger('shipping_id');
            $table->decimal('subtotal');
            $table->decimal('discount');
            $table->decimal('ecotax');
            $table->decimal('vat');
            $table->decimal('total');
            $table->tinyInteger('payment')->default(1)->comment('1=cash on delivery');
            $table->tinyInteger('order_status')->default(1);
            $table->tinyInteger('payment_status')->default(0)->comment('1=successful,2=unsuccessful');
            $table->tinyInteger('isactive')->default(1);
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('billing_id')->references('id')->on('addresses');
            $table->foreign('shipping_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordersummery');
    }
}
