<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('users');
            $table->foreignId('produk_id')->constrained();
            $table->integer('jumlah')->nullable();
            $table->integer('harga_jasa_pengiriman')->default(0);
            $table->integer('total_harga')->nullable();
            $table->string('status_checkout')->nullable();
            $table->string('status_order')->nullable();
            $table->integer('status_feedback')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
