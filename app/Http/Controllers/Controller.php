<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
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
        return view('buku.home');
    }

    public function Peminjaman(){
        return view('peminjaman.home');
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
}
