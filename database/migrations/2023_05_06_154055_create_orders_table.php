<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("uid")->nullable();
            $table->unsignedBigInteger("from_id");
            $table->unsignedBigInteger("to_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("payment_id")->nullable();
            $table->integer("status")->default(0);
            // 0- processing
            // 1- accepted
            // 2- on process
            // 3-  completed

            $table->foreign('from_id')->references("id")->on("users")->onDelete('cascade');
            $table->foreign('to_id')->references("id")->on("users")->onDelete('cascade');
            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');
            $table->foreign('payment_id')->references("id")->on("payments")->onDelete('cascade');

            $table->float("price")->default(0);
            $table->string("ipaddress")->nullable();

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
        Schema::dropIfExists('orders');
    }
}
