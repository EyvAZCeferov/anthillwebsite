<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->default(0);
            $table->string('transaction_id')->nullable();
            $table->integer('payment_status')->default(0);

            // 0 not payed
            // 1 payed
            
            $table->unsignedBigInteger('from_id');
            $table->unsignedBigInteger('to_id')->nullable();
            $table->foreign('from_id')->references("id")->on("users")->onDelete('cascade');
            $table->foreign('to_id')->references("id")->on("users")->onDelete('cascade');


            $table->json('data')->nullable();
            $table->json('frompayment')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
