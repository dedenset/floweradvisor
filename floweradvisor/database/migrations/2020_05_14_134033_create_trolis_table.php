<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrolisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trolis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subtotal');
            $table->string('tipe_discount')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('total');
            $table->string('kupon_kode')->nullable();
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
        Schema::dropIfExists('trolis');
    }
}
