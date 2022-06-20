<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
            $table->integer('jumlah_bayar');
            $table->string('status', 50);
            $table->date('tanggal_bayar');
            $table->string('metode_bayar', 50);
            $table->string('bukti_bayar', 100)->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
};
