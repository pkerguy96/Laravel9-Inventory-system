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
            $table->date('date')->nullable();

            $table->text('description')->nullable();
            $table->double('total_qte')->nullable();
            $table->double('discount')->nullable();

            $table->integer('created_by');




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
