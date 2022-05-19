<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderinfo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ordersummery_id');
            $table->bigInteger('product_id');
            $table->decimal('product_price')->comment('Purchase time product price');
            $table->integer('quantity');
            $table->tinyInteger('isactive')->default(1);
            $table->timestamps();
            $table->foreign('ordersummery_id')->references('id')->on('ordersummery');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderinfo');
    }
}
