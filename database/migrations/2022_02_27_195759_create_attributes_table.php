<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->json("name")->nullable();
            $table->json("slugs")->nullable();

            $table->unsignedBigInteger("group_id")->nullable();
            $table->foreign('group_id')->references("id")->on("attributes")->onDelete('cascade');
            $table->string('datatype')->default('string');
            // string
            // mm
            // sm
            // dm
            $table->integer('order_att')->default(1);
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
        Schema::dropIfExists('attributes');
    }
}