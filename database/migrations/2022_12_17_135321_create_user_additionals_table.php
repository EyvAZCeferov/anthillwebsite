<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_additionals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');


            $table->json('company_name')->nullable();
            $table->json('company_slugs')->nullable();
            // companyname or vasiteci

            $table->json('company_address')->nullable();
            $table->string('company_image')->nullable();
            // logo
            $table->json('company_description')->nullable();
            
            $table->string('original_pass')->nullable();

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
        Schema::dropIfExists('user_types');
    }
}
