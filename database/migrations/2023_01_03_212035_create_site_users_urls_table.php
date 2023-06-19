<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteUsersUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_users_urls', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references("id")->on("site_users")->onDelete('cascade');
           
            $table->text("url");
            $table->text("previous_url")->nullable();
           
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
        Schema::dropIfExists('site_users_urls');
    }
}
