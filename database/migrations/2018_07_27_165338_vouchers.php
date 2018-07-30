<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vouchers')->unique()->index();
            $table->integer('user_id')->references('id')
                ->on('users')->onDelete('cascade')->nullable();
            $table->integer('special_offer_id')->references('id')
                ->on('special_offers');
            $table->integer('usage')->default(0);
            $table->timestamp('usage_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
