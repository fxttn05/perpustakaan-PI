<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function Home(){
        return view('dashboard');
    }

    public function Anggota(){
        return view('anggota.home');
    }

    public function Buku(){
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('buku.home', compact('kategori'));
    }

    public function Kategori (){
        return view('kategori.home');
    }

    public function Peminjaman(){
        $anggota=Anggota::orderBy('nama_lengkap')->get();

        $buku=Buku::where('jumlah_tersedia','>',0)
        ->orderBy('judul_buku')
        ->get();
        
        return view('peminjaman.home',compact(
        'anggota',
        'buku'
        ));
        return view('peminjaman.home', compact('anggota','buku'));
    }

    public function Pengembalian(){
        return view('pengembalian.home');
    }

    public function Denda(){
        return view('denda.home');
    }

    public function Laporan(){
        return view('laporan.home');
    }

    public function Profile(){
        return view('profile.home');
    }
}
