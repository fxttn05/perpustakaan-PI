<?php

use App\Models\Buku;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;
    public string $search = '';
    public ?string $sortField = null;
    public ?string $sortDirection = null;
    public ?Buku $selectedBook = null;

    public function mount()
    {
        if(session()->has('remember_book')){
            $this->selectedBook = Buku::with('kategori')
                ->where('kode_buku', session('remember_book'))
                ->first();
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($field)
    {
        if ($this->sortField !== $field) {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
            return;
        }

        if ($this->sortDirection === 'asc') {
            $this->sortDirection = 'desc';
            return;
        }

        if ($this->sortDirection === 'desc') {
            $this->sortField = null;
            $this->sortDirection = null;
            return;
        }

        $this->sortDirection = 'asc';
    }

    public function pilihBuku($id)
    {
        $this->selectedBook = Buku::with('kategori')->find($id);
    }

    public function with(): array
    {
        $query = Buku::with('kategori');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode_buku','like','%' . $this->search . '%')
                ->orWhere('judul_buku','like','%' . $this->search . '%')
                ->orWhereHas('kategori', function ($kategori) {
                    $kategori->where('nama_kategori','like','%' . $this->search . '%');
                });
            });
        }

        if ($this->sortField) {
            if ($this->sortField == 'kategori') {
                $query
                    ->join('kategoris','bukus.kategori_id','=','kategoris.id')
                    ->orderBy('kategoris.nama_kategori',$this->sortDirection)
                    ->select('bukus.*');
            } else {
                $query->orderBy(
                    $this->sortField,
                    $this->sortDirection
                );

            }
        } else {
            $query->latest();
        }
        return [
            'bukus' => $query->paginate(30)
        ];
    }
};

?>

<div>
    <div class="flex justify-between items-center mb-6">
        <button onclick="openTambahModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium">
            + Tambah Buku
        </button>
        <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari kode buku, judul atau kategori..." class="w-96 rounded-lg border border-slate-300 px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>

    <div class="grid grid-cols-10 gap-3">
        <div class="col-span-5">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100">
                            <tr>
                                <th wire:click="sort('kode_buku')" class="px-4 py-3 text-left cursor-pointer select-none">
                                    <div class="flex items-center gap-2">
                                        Kode
                                        @if($sortField!='kode_buku')
                                            ↕
                                        @elseif($sortDirection=='asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="sort('judul_buku')" class="px-4 py-3 text-left cursor-pointer select-none">
                                    <div class="flex items-center gap-2">
                                        Judul
                                        @if($sortField!='judul_buku')
                                            ↕
                                        @elseif($sortDirection=='asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    </div>
                                </th>
                                <th wire:click="sort('kategori')" class="px-4 py-3 text-left cursor-pointer select-none">
                                    <div class="flex items-center gap-2">
                                        Kategori
                                        @if($sortField!='kategori')
                                            ↕
                                        @elseif($sortDirection=='asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left">Penerbit</th>
                                <th class="px-4 py-3 text-center"> </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($bukus as $item)
                                <tr class="border-t hover:bg-slate-50 transition @if($selectedBook?->id==$item->id)bg-blue-50 border-l-4 border-blue-600 @endif">
                                    <td class="px-4 py-3 font-medium whitespace-nowrap">
                                        {{ $item->kode_buku }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">
                                            {{ $item->judul_buku }}
                                        </div>
                                        {{-- <div class="mt-2 flex gap-2">
                                            <span class="text-xs rounded-full bg-slate-100 px-2 py-1">
                                                Total
                                                {{ $item->jumlah_total }}
                                            </span>
                                            @if($item->jumlah_tersedia>0)
                                                <span class="text-xs rounded-full bg-green-100 text-green-700 px-2 py-1">
                                                    {{ $item->jumlah_tersedia }}
                                                    tersedia
                                                </span>
                                            @else
                                                <span class="text-xs rounded-full bg-red-100 text-red-700 px-2 py-1">
                                                    Stok Habis
                                                </span>
                                            @endif
                                        </div> --}}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $item->kategori->nama_kategori }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->penerbit }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="pilihBuku({{ $item->id }})" class="rounded-lg bg-slate-200 hover:bg-blue-500 hover:text-white p-2 transition" title="Lihat Detail" onclick="rememberBook({{ $item->id }})">
                                            👁
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-14 text-slate-500">
                                        Belum ada data buku.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t p-4">
                    {{ $bukus->links() }}
                </div>
            </div>
        </div>

        <div class="col-span-5">
            <div class="bg-white rounded-xl shadow h-full min-h-130 p-6">
            @if($selectedBook)
                {{-- <div class="border-b px-6 py-5">
                    <h2 class="text-xl font-bold text-slate-800">Detail Buku</h2>
                    <p class="text-sm text-slate-500 mt-1">Informasi lengkap buku yang dipilih</p>
                </div> --}}

                <div>
                    <div class="grid grid-cols-6 gap-x-10 gap-y-5">                   
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Kode Buku</label>
                            <p class="font-semibold text-slate-800 mt-1">{{ $selectedBook->kode_buku }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">ISBN</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->isbn ?: '-' }}</p>
                        </div>
                        <div class="col-span-6">
                            <label class="text-sm text-slate-500">Judul Buku</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->judul_buku }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Kategori</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->kategori->nama_kategori }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Penulis</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->penulis }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Tahun Terbit</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->tahun_terbit }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Penerbit</label>
                            <p class="font-semibold mt-1"> {{ $selectedBook->penerbit }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="text-sm text-slate-500">Status</label>
                            <div class="mt-2">
                                @if($selectedBook->status=='Tersedia')
                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                        Tersedia
                                    </span>
                                @elseif($selectedBook->status=='Dipinjam')
                                    <span class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="text-sm text-slate-500">Jumlah Total</label>
                            <div class="mt-2">
                                <span class="bg-slate-100 rounded-full px-3 py-1">
                                    {{ $selectedBook->jumlah_total }} Buku
                                </span>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="text-sm text-slate-500">Jumlah Tersedia</label>
                            <div class="mt-2">
                                @if($selectedBook->jumlah_tersedia>0)
                                    <span class="bg-green-100 text-green-700 rounded-full px-3 py-1"> 
                                        {{ $selectedBook->jumlah_tersedia }} Buku
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 rounded-full px-3 py-1">
                                        Stok Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Ditambahkan</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="text-sm text-slate-500">Terakhir Diubah</label>
                            <p class="font-semibold mt-1">{{ $selectedBook->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex gap-4">
                        <button onclick="rememberBook({{ $selectedBook->id }}); openEditModal(this)" data-id="{{ $selectedBook->id }}" data-kode="{{ $selectedBook->kode_buku }}" data-judul="{{ $selectedBook->judul_buku }}" data-penerbit="{{ $selectedBook->penerbit }}" data-penulis="{{ $selectedBook->penulis }}" data-isbn="{{ $selectedBook->isbn }}" data-tahun="{{ $selectedBook->tahun_terbit }}" data-total="{{ $selectedBook->jumlah_total }}" data-tersedia="{{ $selectedBook->jumlah_tersedia }}" data-kategori="{{ $selectedBook->kategori_id }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg">
                            Edit Buku
                        </button>
                        <button onclick="deleteBook({{$selectedBook->id}})" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg">
                            Hapus Buku
                        </button>
                    </div>
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center h-130 text-center">
                    <div class="text-7xl">📚</div>
                    <h2 class="mt-6 text-2xl font-bold text-slate-700">Pilih salah satu buku</h2>
                    <p class="mt-2 text-slate-500">Klik tombol <span class="font-semibold">👁</span> pada tabel sebelah kiri untuk melihat informasi lengkap buku.
                    </p>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>