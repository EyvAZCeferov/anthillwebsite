<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_surname', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 17)->unique();
            $table->string('phone_2', 17)->nullable()->unique();
            $table->string('password', 255);
            $table->boolean("is_admin")->default(false);
            $table->integer("type")->default(1); 
            //1- StandartUser
            //2- Shirket
           
            $table->rememberToken();
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('users');
    }
}
