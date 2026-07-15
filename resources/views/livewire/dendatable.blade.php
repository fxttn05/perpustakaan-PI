<?php

use App\Models\Denda;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component{

    use WithPagination;

    public string $search='';

    public ?string $sortField=null;

    public ?string $sortDirection=null;

    public ?int $selectedId=null;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function pilih($id){
        $this->selectedId=$id;
    }

    public function sort($field){

        if($this->sortField!=$field){
            $this->sortField=$field;
            $this->sortDirection='asc';
            return;
        }

        if($this->sortDirection=='asc'){
            $this->sortDirection='desc';
            return;
        }

        if($this->sortDirection=='desc'){
            $this->sortField=null;
            $this->sortDirection=null;
            return;
        }

        $this->sortDirection='asc';

    }

    public function with(): array
    {
        $query=Denda::with([
            'detail.buku.kategori',
            'detail.peminjaman.anggota'
        ]);

        if($this->search){
            $query->where(function($q){
                $q->where('id','like',"%{$this->search}%")
                ->orWhereHas('detail.peminjaman.anggota',function($anggota){
                    $anggota->where('nama_lengkap','like',"%{$this->search}%")->orWhere('kode_anggota','like',"%{$this->search}%");
                })
                ->orWhereHas('detail.buku',function($buku){
                    $buku->where('judul_buku','like',"%{$this->search}%")->orWhere('kode_buku','like',"%{$this->search}%");

                });
            });
        }

        if($this->sortField){

            if($this->sortField=='nama'){
                $query
                    ->join('detail_peminjamans','detail_peminjamans.id','=','dendas.detail_peminjaman_id')
                    ->join('peminjamans','peminjamans.id','=','detail_peminjamans.peminjaman_id')
                    ->join('anggotas','anggotas.id','=','peminjamans.anggota_id')
                    ->select('dendas.*')
                    ->orderBy('anggotas.nama_lengkap',$this->sortDirection);
            }else{
                $query->orderBy($this->sortField,$this->sortDirection);
            }

        }else{

            $query
                ->orderByRaw("CASE WHEN status='Belum Lunas' THEN 0 ELSE 1 END")
                ->latest();

        }

        $data=$query->paginate(30);

        $selected=null;

        if($this->selectedId){
            $selected=Denda::with([
                'detail.buku.kategori',
                'detail.peminjaman.anggota'
            ])->find($this->selectedId);
        }

        return[
            'dendas'=>$data,
            'selected'=>$selected
        ];
    }

};

?>
<div>
    <div class="flex justify-between items-center mb-6">
        <div></div>
        <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari nama atau kode anggota..." class="w-96 border rounded-lg px-4 py-2">
    </div>
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-100">
                    <tr>

                        <th wire:click="sort('id')" class="px-4 py-3 cursor-pointer">
                            ID
                            @if($sortField!='id')
                                ↕
                            @elseif($sortDirection=='asc')
                                ↑
                            @else
                                ↓
                            @endif
                        </th>

                        <th wire:click="sort('nama')" class="px-4 py-3 cursor-pointer">
                            Nama
                            @if($sortField!='nama')
                                ↕
                            @elseif($sortDirection=='asc')
                                ↑
                            @else
                                ↓
                            @endif
                        </th>

                        <th class="px-4 py-3">
                            Buku
                        </th>

                        <th class="px-4 py-3">
                            Denda
                        </th>

                        <th class="px-4 py-3">
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($dendas as $item)

                        <tr
                            class="border-t hover:bg-slate-50 {{ $item->status=='Belum Lunas' ? 'border-l-4 border-red-500' : 'opacity-60' }}">

                            <td class="px-4 py-3">
                                {{ $item->id }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->detail->peminjaman->anggota->nama_lengkap }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->detail->buku->judul_buku }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-red-600">
                                Rp
                                {{ number_format($item->nominal,0,',','.') }}
                            </td>

                            <td class="px-4 py-3">
                                <button wire:click="pilih({{ $item->id }})"
                                    class="rounded-lg bg-slate-200 hover:bg-blue-500 hover:text-white p-2">
                                    👁
                                </button>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Belum ada data denda.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
            <div class="p-4">
                {{ $dendas->links() }}
            </div>
        </div>
        <div class="bg-white rounded-xl shadow min-h-175">
            @if($selected)
            <div class="border-b px-6 py-5 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        Detail Denda
                    </h2>
                    <p class="text-slate-500 mt-1">
                        Informasi lengkap pembayaran denda.
                    </p>
                </div>
            
                @if($selected->status=='Belum Lunas')
                <button onclick="confirmBayar('{{ route('denda.bayar',$selected->id) }}')" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                    Bayar Denda
                </button>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-x-10 gap-y-5 p-6">
            
                <div>
                    <label class="text-sm text-slate-500">ID Denda</label>
                    <p class="font-semibold mt-1">
                        DND-{{ str_pad($selected->id,4,'0',STR_PAD_LEFT) }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Tanggal Dibuat</label>
                    <p class="font-semibold mt-1">
                        {{ \Carbon\Carbon::parse($selected->created_at)->format('d M Y') }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Kode Anggota</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->detail->peminjaman->anggota->kode_anggota }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Nama Anggota</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->detail->peminjaman->anggota->nama_lengkap }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Kelas</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->detail->peminjaman->anggota->kelas ?: '-' }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Jabatan</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->detail->peminjaman->anggota->jabatan }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Buku</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->detail->buku->judul_buku }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Kategori</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->detail->buku->kategori->nama_kategori }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Tanggal Pinjam</label>
                    <p class="font-semibold mt-1">
                        {{ \Carbon\Carbon::parse($selected->detail->tanggal_pinjam)->format('d M Y') }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Jatuh Tempo</label>
                    <p class="font-semibold mt-1">
                        {{ \Carbon\Carbon::parse($selected->detail->tanggal_jatuh_tempo)->format('d M Y') }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Periode Terlambat</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->periode_terlambat }} Periode
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Nominal</label>
                    <p class="font-bold text-red-600 mt-1">
                        Rp {{ number_format($selected->nominal,0,',','.') }}
                    </p>
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Status</label>
                
                    @if($selected->status=='Belum Lunas')
                        <span class="inline-block mt-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                            Belum Lunas
                        </span>
                    @else
                        <span class="inline-block mt-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            Lunas
                        </span>
                    @endif
                    
                </div>
            
                <div>
                    <label class="text-sm text-slate-500">Tanggal Bayar</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->tanggal_bayar ? \Carbon\Carbon::parse($selected->tanggal_bayar)->format('d M Y') : '-' }}
                    </p>
                </div>
            
                <div class="col-span-2">
                    <label class="text-sm text-slate-500">Keterangan</label>
                    <p class="font-semibold mt-1">
                        {{ $selected->keterangan ?: '-' }}
                    </p>
                </div>
            
            </div>

            @else

            <div class="h-full flex flex-col items-center justify-center min-h-175">
                <div class="text-7xl mb-5">💰</div>
                <h2 class="text-2xl font-semibold">
                    Pilih salah satu data denda
                </h2>
                <p class="text-slate-500 mt-3 text-center max-w-md">
                    Tekan tombol <b>👁</b> pada daftar denda untuk melihat informasi lengkap pembayaran.
                </p>
            </div>

            @endif
        </div>
    </div>
</div>
