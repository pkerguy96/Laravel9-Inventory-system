<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_form_details', function (Blueprint $table) {
            $table->id();
            $table->integer('orderform_id');
            $table->integer('brand_id');
            $table->integer('category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->double('qte')->nullable();
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
        Schema::dropIfExists('order_form_details');
    }
};
