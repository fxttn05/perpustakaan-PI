<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';
    protected $fillable = [
        'id_peminjaman',
        'anggota_id',
        'tanggal_pinjam',
        'status',
        'keterangan'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
    
    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
