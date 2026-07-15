<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul_buku'       => 'required|max:255',
            'penulis'          => 'required|max:255',
            'penerbit'         => 'required|max:255',
            'tahun_terbit'     => 'required|digits:4',
            'kategori_id'      => 'required',
            'jumlah_total'     => 'required|integer|min:1',
            'jumlah_tersedia'  => 'required|integer|min:0|lte:jumlah_total'
        ]);

        $last = Buku::latest()->first();
        if (!$last) {
            $kode = 'TB-0001';
        } else {
            $angka = intval(substr($last->kode_buku, -4));
            $angka++;
            $kode = 'TB-' . str_pad($angka, 4, '0', STR_PAD_LEFT);
        }

        $buku = Buku::create([
            'kode_buku'         => $kode,
            'judul_buku'        => $request->judul_buku,
            'penulis'           => $request->penulis,
            'penerbit'          => $request->penerbit,
            'isbn'              => $request->isbn,
            'tahun_terbit'      => $request->tahun_terbit,
            'kategori_id'       => $request->kategori_id,
            'jumlah_total'      => $request->jumlah_total,
            'jumlah_tersedia'   => $request->jumlah_tersedia,
            'status'            => 'Tersedia',
            'keterangan'        => $request->keterangan,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return back()->with('remember_book', $buku->kode_buku)->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul_buku'        => 'required|max:255',
            'penulis'           => 'required|max:255',
            'penerbit'          => 'required|max:255',
            'tahun_terbit'      => 'required|digits:4',
            'kategori_id'       => 'required|',
            'jumlah_total'      => 'required|integer|min:1',
            'jumlah_tersedia'   => 'required|integer|min:0|lte:jumlah_total'
        ]);
        $buku->update([
            'judul_buku'        => $request->judul_buku,
            'penulis'           => $request->penulis,
            'penerbit'          => $request->penerbit,
            'isbn'              => $request->isbn,
            'tahun_terbit'      => $request->tahun_terbit,
            'kategori_id'       => $request->kategori_id,
            'jumlah_total'      => $request->jumlah_total,
            'jumlah_tersedia'   => $request->jumlah_tersedia,
            'status'            => $request->jumlah_tersedia < $request->jumlah_total ? 'Dipinjam' : 'Tersedia',
            'keterangan'        => $request->keterangan,
            'updated_at'        => now()
        ]);
        return back()->with('remember_book', $buku->kode_buku)->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return back()->with('success', 'Data buku berhasil dihapus.');

    }
}
