<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'=>'required|exists:anggotas,id',
            'tanggal_pinjam'=>'required|date',
            'buku_id'=>'required|array|min:1|max:6',
            'periode'=>'required|array'
        ]);

        DB::beginTransaction();

        try{
            $last=Peminjaman::orderByDesc('id')->first();
            if(!$last){
                $kode='PMJ-0001';
            }else{
                $angka=(int)substr($last->id_peminjaman,-4);
                $kode='PMJ-'.str_pad($angka+1,4,'0',STR_PAD_LEFT);
            }

            $pinjam=Peminjaman::create([
                'id_peminjaman'=>$kode,
                'anggota_id'=>$request->anggota_id,
                'tanggal_pinjam'=>$request->tanggal_pinjam,
                'status'=>'Dipinjam',
                'keterangan'=>$request->keterangan
            ]);

            foreach($request->buku_id as $index=>$bukuId){
                $buku=Buku::findOrFail($bukuId);
                if($buku->jumlah_tersedia<=0){
                    throw new \Exception("Stok {$buku->judul_buku} habis.");
                }

                $periode=(int)$request->periode[$index];
                $durasi=$periode*7;
                DetailPeminjaman::create([
                    'peminjaman_id'=>$pinjam->id,
                    'buku_id'=>$buku->id,
                    'tanggal_pinjam'=>$request->tanggal_pinjam,
                    'periode'=>$periode,
                    'durasi'=>$durasi,
                    'jumlah_perpanjangan'=>0,
                    'tanggal_jatuh_tempo'=>Carbon::parse($request->tanggal_pinjam)->addDays($durasi),
                    'status'=>'Dipinjam'
                ]);

                $buku->decrement('jumlah_tersedia');
                if($buku->fresh()->jumlah_tersedia==0){
                    $buku->status='Dipinjam';
                    $buku->save();
                }
            }

            DB::commit();
            return redirect()->route('peminjaman',['selected' => $pinjam->id])->with('success','Peminjaman berhasil ditambahkan.');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    public function kembaliSemua(Peminjaman $peminjaman)
    {
        DB::beginTransaction();
    
        try{
    
            foreach($peminjaman->details()->where('status','!=','Dikembalikan')->get() as $detail){
    
                $detail->update([
                    'status'=>'Dikembalikan'
                ]);
    
                $detail->buku->increment('jumlah_tersedia');
    
                $detail->buku->update([
                    'status'=>'Tersedia'
                ]);
            }
    
            $peminjaman->update([
                'status'=>'Selesai'
            ]);
    
            DB::commit();
    
            return redirect()
                ->route('peminjaman',['selected'=>$peminjaman->id])
                ->with('success','Seluruh buku berhasil dikembalikan.');
    
        }catch(\Exception $e){
    
            DB::rollBack();
    
            return back()->withErrors($e->getMessage());
        }
    }

    public function perpanjang(DetailPeminjaman $detail){
        if($detail->status=='Dikembalikan'){
            return back();
        }

        $detail->update([
            'periode'=>$detail->periode+1,
            'durasi'=>($detail->periode+1)*7,
            'jumlah_perpanjangan'=>$detail->jumlah_perpanjangan+1,
            'tanggal_jatuh_tempo'=>Carbon::parse($detail->tanggal_jatuh_tempo)->addDays(7),
            'updated_at'=>now()
        ]);

        return back()->with('success','Periode berhasil diperpanjang.');
    }

    public function kembali(DetailPeminjaman $detail){
        if($detail->status=='Dikembalikan'){
            return back();
        }
        $detail->update([
            'status'=>'Dikembalikan',
            'updated_at'=>now()
        ]);
        $buku=$detail->buku;
        $buku->increment('jumlah_tersedia');
        $buku->refresh();

        if($buku->jumlah_tersedia>0){
            $buku->status='Tersedia';
            $buku->save();
        }
        $pinjam=$detail->peminjaman;
        $aktif=$pinjam->details()->where('status','!=','Dikembalikan')->count();

        if($aktif==0){
            $pinjam->update([
                'status'=>'Selesai'
            ]);
        }

        return back()->with('success','Buku berhasil dikembalikan.');
    }
}
