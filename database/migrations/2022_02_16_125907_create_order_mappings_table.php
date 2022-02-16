<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained('users');
            $table->foreignId('produk_id')->constrained();
            $table->foreignId('order_id')->nullable()->unsigned();
            $table->string('status_checkout')->default('Keranjang');
            $table->integer('status_feedback')->default(0);
            $table->integer('jumlah');
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
        Schema::dropIfExists('order_mappings');
    }
}
