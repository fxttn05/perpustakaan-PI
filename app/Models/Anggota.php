<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggotas';

    protected $fillable = [
        'kode_anggota',
        'nama_lengkap',
        'jabatan',
        'kelas',
        'email',
        'no_telp',
        'status'
    ];
}
