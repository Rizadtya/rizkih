<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'kode_anggota',
        'nama',
        'nis',
        'kelas',
        'alamat',
        'no_telepon',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
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
