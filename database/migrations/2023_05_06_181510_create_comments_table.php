<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->integer("rating")->default(0);
            $table->text("comment")->nullable();
            $table->boolean("status")->default(false);

            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');
            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('comments');
    }
}