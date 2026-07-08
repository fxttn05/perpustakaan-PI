<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'nama_kategori'     => 'required|max:255',
        ]);
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('kategori')->with('success','Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori'     => 'required|max:255',
        ]);
        Kategori::findOrFail($id)
            ->update([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
                'updated_at' => now()
            ]);

        return redirect()->route('kategori')->with('success','Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
    
        return redirect()->route('kategori')->with('success','Kategori berhasil dihapus');
    }
}
