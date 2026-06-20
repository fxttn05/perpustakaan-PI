<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
        ]);

        do {$kode = 'PTB-' . rand(100000, 999999);
        } while (
            Anggota::where('kode_anggota', $kode)->exists()
        );

        Anggota::create([
            'kode_anggota' => $kode,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil dibuat');
    }

    public function update(Request $request,$id) {
        $anggota = Anggota::findOrFail($id);
        $anggota->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'kelas' => $request->kelas,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Anggota::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
