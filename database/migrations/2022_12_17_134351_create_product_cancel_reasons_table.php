<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCancelReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cancel_reasons', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger("product_id");
            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');

            $table->json('reason')->nullable();
            // Burda standart cavabları yerləşdirərsən əgər xoşu gəlməsə özü yazsın

            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('product_cancel_reasons');
    }
}
