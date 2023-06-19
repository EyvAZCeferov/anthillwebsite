<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductEncodedImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_encoded_images', function (Blueprint $table) {
            $table->id();
            $table->string('encoded_watermaker_images')->nullable();
            $table->string('encoded_thumbnail_images')->nullable();
            $table->string('original_images')->nullable();
            $table->string('original_compressed_images')->nullable();
            
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');
            
            $table->integer('order_a')->default(1);
            
            $table->string('token',300)->nullable();
            $table->string('code',50)->nullable();
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
        Schema::dropIfExists('product_encoded_images');
    }
}
