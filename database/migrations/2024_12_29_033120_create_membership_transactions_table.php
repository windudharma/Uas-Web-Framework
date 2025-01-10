<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membership_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang membeli
            $table->foreignId('membership_id')->constrained()->onDelete('cascade'); // Paket membership yang dipilih
            $table->dateTime('start_date'); // Tanggal mulai membership
            $table->dateTime('end_date'); // Tanggal akhir membership
            $table->decimal('amount_paid', 10, 2); // Total pembayaran untuk transaksi ini
            $table->string('transaction_type')->default('purchase'); // Jenis transaksi: purchase atau renewal
            $table->integer('downloads_today')->default(0); // Jumlah unduhan yang telah dilakukan hari ini
            $table->timestamps(); // created_at untuk waktu pembelian
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_transactions');
    }
};

