<?php

use App\Models\Kategori;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;
    public string $search = '';
    public ?string $sortField = null;
    public ?string $sortDirection = null;

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
    }

    public function with(): array
    {
        $query = Kategori::query();
        if ($this->search) {
            $query->where('nama_kategori','like',"%{$this->search}%");
        }

        if ($this->sortField) {
            $query->orderBy(
                $this->sortField,
                $this->sortDirection
            );

        } else {
            $query->latest();
        }

        return [
            'kategori' => $query->paginate(20)
        ];
    }

};

?>

<div>
    <div class="flex justify-between items-center mb-6">
        <button onclick="openTambahModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
            + Tambah Kategori
        </button>
        <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari kategori..." class="border rounded-lg px-4 py-2 w-96">
    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th wire:click="sort('nama_kategori')" class="cursor-pointer px-4 py-3">
                    Nama Kategori
                    @if($sortField !== 'nama_kategori')
                    ↕
                    @elseif($sortDirection === 'asc')
                    ↑
                    @else
                    ↓
                    @endif
                    </th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Dibuat</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>

            </thead>

            <tbody>
                @forelse($kategori as $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $item->nama_kategori }}</td>
                    <td class="px-4 py-3">{{ $item->deskripsi }}</td>
                    <td class="px-4 py-3">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded" data-id="{{ $item->id }}" data-nama="{{ $item->nama_kategori }}" data-deskripsi="{{ $item->deskripsi }}" onclick="openEditModal(this)">Edit</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-slate-500">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $anggota->links() }}
    </div>
</div>