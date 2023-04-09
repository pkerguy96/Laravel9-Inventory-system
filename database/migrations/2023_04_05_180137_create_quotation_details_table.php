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
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_id')->nullable();
            $table->integer('brand_id');
            $table->integer('category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->double('qte')->nullable();
            $table->double('unit_price')->nullable();
            $table->double('selling_price')->nullable();
            $table->double('tax_amount');
            $table->double('grand_total');
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
        Schema::dropIfExists('quotation_details');
    }
};
