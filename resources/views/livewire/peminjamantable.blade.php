<?php

use App\Models\Peminjaman;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

new class extends Component {
    use WithPagination;
    public string $search = '';
    public ?string $sortField = null;
    public ?string $sortDirection = null;
    public ?int $selectedId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($field)
    {
        if ($this->sortField != $field) {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
            return;
        }

        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
            return;
        }

        if ($this->sortDirection == 'desc') {
            $this->sortField = null;
            $this->sortDirection = null;
            return;
        }

        $this->sortDirection = 'asc';
    }

    public function pilih($id)
    {
        $this->selectedId = $id;
    }

    public function with(): array
    {
        $query = Peminjaman::with([
            'anggota',
            'details.buku.kategori'
        ]);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id_peminjaman','like',"%{$this->search}%")->orWhereHas('anggota',function($anggota){
                    $anggota->where('nama_lengkap','like',"%{$this->search}%")->orWhere('kode_anggota','like',"%{$this->search}%");
                });
            });
        }

        if ($this->sortField) {
            $query->orderBy($this->sortField,$this->sortDirection);
        } else {
            $query->latest('id');
        }

        $data = $query->paginate(30);
        $selected = null;

        if($this->selectedId){
            $selected = Peminjaman::with([
                'anggota',
                'details.buku.kategori'
            ])->find($this->selectedId);
        }

        return [
            'peminjamans'=>$data,
            'selected'=>$selected
        ];
    }
};

?>

<div>
    <div class="flex justify-between items-center mb-6">
        <button onclick="openTambahModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
            + Tambah Peminjaman
        </button>
        <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari ID, kode anggota atau nama..." class="w-96 border rounded-lg px-4 py-2">
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th wire:click="sort('id_peminjaman')" class="px-4 py-3 cursor-pointer">
                            ID
                            @if($sortField!='id_peminjaman')
                                ↕
                            @elseif($sortDirection=='asc')
                                ↑
                            @else
                                ↓
                            @endif
                        </th>
                        <th wire:click="sort('tanggal_pinjam')" class="px-4 py-3 cursor-pointer">
                            Tanggal
                            @if($sortField!='tanggal_pinjam')
                                ↕
                            @elseif($sortDirection=='asc')
                                ↑
                            @else
                                ↓
                            @endif
                        </th>
                        <th class="px-4 py-3">Peminjam</th>
                        <th class="px-4 py-3">Buku</th>
                        <th class="px-4 py-3"> </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $item)
                        <tr class="border-t hover:bg-slate-50">
                            <td class="px-4 py-3">
                                {{ $item->id_peminjaman }}
                            </td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $item->anggota->nama_lengkap }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                {{ $item->details->count() }}
                            </td>
                            <td class="px-4 py-3">
                                <button wire:click="pilih({{ $item->id }})" class="rounded-lg bg-slate-200 hover:bg-blue-500 hover:text-white p-2 transition" title="Lihat Detail">
                                    👁
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $peminjamans->links() }}
            </div>
        </div>

        {{-- detail buku --}}
        <div class="bg-white rounded-xl shadow min-h-175">

            @if($selected)

            <div class="border-b px-6 py-5 flex justify-between items-center">          
                <div>
                    <h2 class="text-2xl font-bold">
                        Detail Peminjaman
                    </h2>
                    <p class="text-slate-500">
                        Informasi lengkap transaksi peminjaman
                    </p>
                </div>
            
                @if($selected->status=='Dipinjam')
                    <button
                        onclick="confirmKembaliSemua('{{ route('peminjaman.kembaliSemua',$selected) }}')"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                        Kembalikan Semua
                    </button>
                @endif
                
            </div>
        
            <div class="grid grid-cols-6 gap-x-10 gap-y-4 p-6 text-sm">
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">ID Peminjaman</label>
                    <p>{{ $selected->id_peminjaman }}</p>
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Tanggal Pinjam</label>
                    <p>{{ Carbon::parse($selected->tanggal_pinjam)->format('d M Y') }}</p>
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Kode Anggota</label>
                    <p>{{ $selected->anggota->kode_anggota }}</p>
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Nama Anggota</label>
                    <p>{{ $selected->anggota->nama_lengkap }}</p>
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Kelas</label>
                    <p>{{ $selected->anggota->kelas ?? '-' }}</p>
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Jabatan</label>
                    <p>{{ $selected->anggota->jabatan }}</p>
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Status</label>
                
                    @if($selected->status=='Dipinjam')
                        <p class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                            Dipinjam
                        </p>
                    @else
                        <p class="inline-block bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-xs">
                            Selesai
                        </p>
                    @endif
                    
                </div>
            
                <div class="col-span-3">
                    <label class="font-semibold text-slate-500">Jumlah Buku</label>
                    <p>{{ $selected->details->count() }} Buku</p>
                </div>
                <div class="col-span-6">
                    <label class="text-sm text-slate-500">Keterangan</label>
                    <p class="font-semibold mt-1">{{ $selected->keterangan ?: '-'}}</p>
                </div>
            </div>
        
            <div class="border-t">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h3 class="font-semibold text-lg">
                        Daftar Buku
                    </h3>
                    <span class="text-sm text-slate-500">
                        {{ $selected->details->count() }} Buku
                    </span>
                </div>
            
                <div class="divide-y">
                    @foreach($selected->details->sortBy(function($item){
                        if($item->status=='Dipinjam') return 1;
                        if($item->status=='Terlambat') return 2;
                        return 3;
                    }) as $detail)
                    @php
                        $warning = now()->diffInDays($detail->tanggal_jatuh_tempo,false)<=2 && $detail->status!='Dikembalikan';
                    @endphp

                    <div class="px-6 py-5 {{ $warning ? 'border-l-4 border-red-600 bg-red-50' : '' }} {{ $detail->status=='Dikembalikan' ? 'opacity-60' : '' }}">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <h4 class="font-semibold">
                                    {{ $detail->buku->judul_buku }}
                                </h4>
                                <div class="text-sm text-slate-500">
                                    {{ $detail->buku->kode_buku }}
                                    •
                                    {{ $detail->buku->kategori->nama_kategori }}
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <span class="bg-blue-100 text-blue-700 rounded-full px-3 py-1 text-xs">
                                        Periode {{ $detail->periode }}
                                    </span>
                                    <span class="bg-slate-100 text-slate-700 rounded-full px-3 py-1 text-xs">
                                        {{ $detail->durasi }} Hari
                                    </span>
                                    @if($detail->status=='Dipinjam')
                                        <span class="bg-green-100 text-green-700 rounded-full px-3 py-1 text-xs">
                                            Dipinjam
                                        </span>    
                                    @elseif($detail->status=='Terlambat')    
                                        <span class="bg-red-100 text-red-700 rounded-full px-3 py-1 text-xs">
                                            Terlambat
                                        </span>    
                                    @else    
                                        <span class="bg-slate-200 text-slate-700 rounded-full px-3 py-1 text-xs">
                                            Dikembalikan
                                        </span>    
                                    @endif    
                                </div>
                            
                                <div class="mt-3 text-sm"> 
                                    <p>
                                        Pinjam :
                                        <b>{{ Carbon::parse($detail->tanggal_pinjam)->format('d M Y') }}</b>
                                    </p>
                                    <p>
                                        Jatuh Tempo :
                                        <b>{{ Carbon::parse($detail->tanggal_jatuh_tempo)->format('d M Y') }}</b>
                                    </p>
                                    <p>
                                        Perpanjangan :
                                        <b>{{ $detail->jumlah_perpanjangan }} kali</b>
                                    </p>
                                </div>
                            </div>
                        
                            @if($detail->status!='Dikembalikan')
                            <div class="flex flex-col gap-2">
                                <button onclick="confirmPerpanjang('{{ route('peminjaman.perpanjang',$detail) }}')" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm">
                                    Perpanjang
                                </button>
                                <button onclick="confirmKembali('{{ route('peminjaman.kembali',$detail) }}')" class="bg-green-600 hover:bg-green-700 text-white rounded-lg px-4 py-2 text-sm">
                                    Kembalikan
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="h-full flex flex-col items-center justify-center min-h-175">
                <div class="text-4xl mb-5">
                    📚
                </div>
                <h2 class="text-2xl font-semibold">
                    Pilih salah satu peminjaman
                </h2>
                <p class="text-slate-500 mt-3 text-center max-w-md">
                    Tekan tombol <b>👁</b> pada daftar peminjaman untuk melihat informasi lengkap transaksi beserta daftar buku yang sedang dipinjam.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>