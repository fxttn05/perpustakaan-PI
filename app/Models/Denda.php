<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    public function detail()
    {
        return $this->belongsTo(DetailPeminjaman::class,'detail_peminjaman_id');
    }

    protected $fillable = [
        'detail_peminjaman_id',
        'hari_terlambat',
        'periode_terlambat',
        'nominal',
        'status',
        'tanggal_bayar',
        'keterangan'
    ];
}