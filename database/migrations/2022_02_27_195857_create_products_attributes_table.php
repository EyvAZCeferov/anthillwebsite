<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("attribute_group_id");
            $table->unsignedBigInteger("attribute_id");

            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');
            $table->foreign('attribute_group_id')->references("id")->on("attributes")->onDelete('cascade');
            $table->foreign('attribute_id')->references("id")->on("attributes")->onDelete('cascade');
            $table->engine = "InnoDB";
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
        Schema::dropIfExists('products_attributes');
    }
}