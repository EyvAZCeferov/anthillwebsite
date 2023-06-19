<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_counters', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('element_id')->nullable();
            
            $table->unsignedBigInteger('site_user_id');
            $table->foreign('site_user_id')->references("id")->on("site_users")->onDelete('cascade');
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');
            
            $table->string('type')->default('product');
            // product
            // user
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
        Schema::dropIfExists('view_counters');
    }
}
