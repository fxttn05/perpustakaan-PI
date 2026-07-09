<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'penulis',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'jumlah_total',
        'jumlah_tersedia',
        'status',
        'kategori_id',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
