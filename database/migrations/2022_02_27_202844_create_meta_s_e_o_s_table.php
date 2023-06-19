<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaSEOSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_seo', function (Blueprint $table) {
            $table->id();
            $table->json("name")->nullable();
            $table->json("description")->nullable();
            $table->json("keywords")->nullable();
            $table->string("type");
            $table->unsignedBigInteger("element_id");
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
        Schema::dropIfExists('meta_s_e_o_s');
    }
}
