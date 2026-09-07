<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'jumlah_stok',
        'jumlah_tersedia',
        'lokasi_rak',
        'deskripsi',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'jumlah_stok' => 'integer',
        'jumlah_tersedia' => 'integer',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('status', 'dipinjam');
    }
}
