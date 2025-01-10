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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama paket membership
            $table->integer('duration_days'); // Durasi membership (dalam hari)
            $table->integer('daily_limit'); // Batas download per hari
            $table->integer('price'); // Harga paket membership tanpa desimal
            $table->boolean('is_popular')->default(false); // Penanda apakah paket populer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
