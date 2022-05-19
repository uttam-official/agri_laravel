<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id()->from(1000000);
            $table->string('firstname',25);
            $table->string('lastname',25);
            $table->string('email',50)->unique();
            $table->string('phone',11);
            $table->string('fax',12)->nullable();
            $table->string('password',64);
            $table->tinyInteger('newsletter')->default(0)->comment('1=Subscribed,2=Non Subscribed');
            $table->tinyInteger('isactive')->default(1);
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
        Schema::dropIfExists('customers');
    }
}
