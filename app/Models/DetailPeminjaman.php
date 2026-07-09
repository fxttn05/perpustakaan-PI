<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;
    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'tanggal_pinjam',
        'periode',
        'durasi',
        'jumlah_perpanjangan',
        'tanggal_jatuh_tempo',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
    
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function isUrgent()
    {
        if ($this->status != 'Dipinjam')
            return false;

        return now()->diffInDays($this->tanggal_jatuh_tempo, false) <= 2;
    }

    public function isLate()
    {
        return now()->greaterThan($this->tanggal_jatuh_tempo) && $this->status == 'Dipinjam';
    }
}
