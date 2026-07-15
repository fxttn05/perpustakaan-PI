<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function bayar(Request $request,Denda $denda)
    {
        $request->validate([
            'keterangan'=>'nullable|string'
        ]);
    
        $denda->update([
            'status'=>'Lunas',
            'tanggal_bayar'=>today(),
            'keterangan'=>$request->keterangan
        ]);
    
        if($denda->status=='Lunas'){
            return back();
        }
    }
}
