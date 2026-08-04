<?php

namespace App\Console\Commands;

use App\Models\Denda;
use App\Models\DetailPeminjaman;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateDenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-denda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(){
        $details=DetailPeminjaman::whereIn('status',['Dipinjam','Terlambat'])
            ->with('denda')
            ->get();
        foreach($details as $detail){
            $hariTelat = Carbon::parse($detail->tanggal_jatuh_tempo)->diffInDays(Carbon::today(), false);

            if($hariTelat <= 0){
                continue;
            }

            $periodeTelat = max(1, ceil($hariTelat / 7));
            $periodeTelat=(int)ceil($hariTelat/7);
            if($periodeTelat<1){
                $periodeTelat=1;
            }
            $nominal=$periodeTelat*5000;
            Denda::updateOrCreate(
                [
                    'detail_peminjaman_id'=>$detail->id
                ],
                [
                    'hari_terlambat' => $hariTelat,
                    'periode_terlambat'=>$periodeTelat,
                    'nominal'=>$nominal,
                    'status'=>'Belum Lunas'
                ]
            );
            if($detail->status!='Terlambat'){
                $detail->update([
                    'status'=>'Terlambat'
                ]);
            }
        }

        return Command::SUCCESS;
    }
    
}
