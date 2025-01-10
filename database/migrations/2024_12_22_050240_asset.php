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
        Schema::create('assets', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('kode', 50)->nullable()->unique(); // Kode aset unik
            $table->string('nama_aset', 255)->nullable(); // Nama aset
            $table->enum('jenis_aset', ['Vector', 'Image', 'Template'])->nullable(); // Jenis aset dengan enum
            $table->text('deskripsi')->nullable(); // Deskripsi aset (diperpanjang dari string ke text)
            $table->string('kategori', 100)->nullable(); // Kategori aset
            $table->string('gambar')->nullable(); // Path gambar
            $table->string('file_zip')->nullable(); // Path file ZIP
            $table->boolean('is_aktif')->default(true); // Status aktif aset
            $table->timestamps(); // Created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets'); // Nama tabel harus konsisten
    }
};
