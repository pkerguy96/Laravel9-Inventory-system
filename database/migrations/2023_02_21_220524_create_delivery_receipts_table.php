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
        Schema::create('delivery_receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('delivery_no')->nullable();
            $table->integer('brand_id');
            $table->integer('category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->double('qte')->nullable();
            $table->double('selling_price')->nullable();
            $table->double('sub_total');
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
        Schema::dropIfExists('delivery_receipts');
    }
};
