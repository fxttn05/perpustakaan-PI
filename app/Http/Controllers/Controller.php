<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Kategori;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function Home(){
        $totalBuku = Buku::sum('jumlah_total');
        $totalAnggota = Anggota::count();
        $bukuDipinjam = DetailPeminjaman::whereIn('status',['Dipinjam','Terlambat'])->count();

        $totalDenda = 0;
        $riwayatPinjam = DetailPeminjaman::with([
            'buku',
            'peminjaman.anggota'
        ])->latest()->take(5)->get();

        $riwayatKembali = DetailPeminjaman::with(['buku','peminjaman.anggota'])->where('status','Dikembalikan')->latest('updated_at')->take(5)->get();

        $kategori = DB::table('detail_peminjamen')
                    ->join('bukus','detail_peminjamen.buku_id','=','bukus.id')
                    ->join('kategoris','bukus.kategori_id','=','kategoris.id')
                    ->select('kategoris.nama_kategori',DB::raw('count(*) as total'))
                    ->groupBy('kategoris.nama_kategori')
                    ->orderByDesc('total')
                    ->get();

        return view('dashboard',[
            'totalBuku'=>$totalBuku,
            'totalAnggota'=>$totalAnggota,
            'bukuDipinjam'=>$bukuDipinjam,
            'totalDenda'=>$totalDenda,
            'riwayatPinjam'=>$riwayatPinjam,
            'riwayatKembali'=>$riwayatKembali,
            'kategori'=>$kategori
        ]);
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
