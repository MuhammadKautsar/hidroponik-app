<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjual_id')->constrained('users');
            $table->integer('promo_id')->nullable()->unsigned();
            $table->string('nama');
            $table->integer('harga');
            $table->integer('stok');
            $table->integer('total_feedback')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('satuan')->nullable();
            $table->integer('jumlah_per_satuan')->nullable();
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
        Schema::dropIfExists('produks');
    }
}
