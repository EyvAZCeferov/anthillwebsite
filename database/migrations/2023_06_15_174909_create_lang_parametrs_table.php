<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangParametrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lang_parametrs', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("locale")->default("en");
            $table->string("keyword")->default("chatnow");
            // chatnow
            // sharecooment
            // filterviewbutton
            // morebutton
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
        Schema::dropIfExists('lang_parametrs');
    }
}
