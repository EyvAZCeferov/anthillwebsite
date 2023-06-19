<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            // imagelərin papkasi bu idynən olacaq
            $table->json("name")->nullable();
            $table->json("address")->nullable();
            $table->json("contactinfo")->nullable();
            $table->string("code")->nullable();
            $table->json('description')->nullable();
            $table->json("slugs")->nullable();
            $table->float("price")->default(0);
            $table->integer("status")->default(0);    
            // 0 - təsdiq gözləyir
            // 1 - təsdiq edilməyib
            // 2 - təsdiq edilib
            // 3 - expired
            // 4 - waiting payment
            
            $table->unsignedBigInteger("category_id");
            $table->foreign('category_id')->references("id")->on("categories")->onDelete('cascade');

            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');

            $table->string("token")->unique();

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
        Schema::dropIfExists('products');
    }
}
