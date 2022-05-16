<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('category');
            $table->integer('subcategory');
            $table->decimal('price');
            $table->string('image_extension');
            $table->tinyInteger('availability')->default(1);
            $table->tinyInteger('special')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('isactive')->default(1);
            $table->timestamps();
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('subcategory')->references('id')->on('categories');
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
