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
            'penulis'        => 'required|max:255',
            'penerbit'         => 'required|max:255',
            'isbn'             => 'nullable|max:100',
            'tahun_terbit'     => 'required|digits:4',
            'kategori_id'      => 'required|exists:kategoris,id',
            'jumlah_total'     => 'required|integer|min:1',
            'jumlah_tersedia'  => 'required|integer|min:0'
        ]);

        $last = Buku::latest()->first();
        if (!$last) {
            $kode = 'TB-0001';
        } else {
            $angka = intval(substr($last->kode_buku, -4));
            $angka++;
            $kode = 'TB-' . str_pad($angka, 4, '0', STR_PAD_LEFT);
        }

        Buku::create([
            'kode_buku'         => $kode,
            'judul_buku'        => $request->judul_buku,
            'penulis'         => $request->penulis,
            'penerbit'          => $request->penerbit,
            'isbn'              => $request->isbn,
            'tahun_terbit'      => $request->tahun_terbit,
            'kategori_id'       => $request->kategori_id,
            'jumlah_total'      => $request->jumlah_total,
            'jumlah_tersedia'   => $request->jumlah_tersedia,
            'status'            => $request->jumlah_tersedia == 0 ? 'Dipinjam' : 'Tersedia',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('buku')->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul_buku'        => 'required|max:255',
            'penulis'         => 'required|max:255',
            'penerbit'          => 'required|max:255',
            'isbn'              => 'nullable|max:100',
            'tahun_terbit'      => 'required|digits:4',
            'kategori_id'       => 'required|exists:kategoris,id',
            'jumlah_total'      => 'required|integer|min:1',
            'jumlah_tersedia'   => 'required|integer|min:0'
        ]);
        $status = 'Tersedia';
        if ($request->jumlah_tersedia == 0) {
            $status = 'Dipinjam';
        }
        $buku->update([
            'judul_buku'        => $request->judul_buku,
            'penulis'         => $request->penulis,
            'penerbit'          => $request->penerbit,
            'isbn'              => $request->isbn,
            'tahun_terbit'      => $request->tahun_terbit,
            'kategori_id'       => $request->kategori_id,
            'jumlah_total'      => $request->jumlah_total,
            'jumlah_tersedia'   => $request->jumlah_tersedia,
            'status'            => $status,
            'updated_at'        => now()
        ]);
        return redirect()->route('buku')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku')->with('success', 'Data buku berhasil dihapus.');

    }
}
