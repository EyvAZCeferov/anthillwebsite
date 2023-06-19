<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); 
            $table->json('name')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->json('slugs')->nullable();
            $table->boolean("status")->default(true);
            $table->string('color')->default('#fff');
            
            $table->unsignedBigInteger("top_id")->nullable();
            $table->foreign('top_id')->references("id")->on("categories")->onDelete('cascade');
            
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
        Schema::dropIfExists('categories');
    }
}
