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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 50)->unique();
            $table->string('judul', 200);
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->string('kategori', 50);
            $table->integer('jumlah_stok')->default(0);
            $table->integer('jumlah_tersedia')->default(0);
            $table->string('lokasi_rak', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index('kode_buku');
            $table->index('kategori');
            $table->index('judul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
