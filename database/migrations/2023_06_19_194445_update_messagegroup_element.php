<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMessagegroupElement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_groups', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id")->nullable();
            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');
        });

        Schema::table('products_attributes', function (Blueprint $table) {
            $table->integer("order_att")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
