<?php

use App\Models\Anggota;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new class extends Component
{
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

        $this->sortDirection = 'asc';
    }

    public function with(): array
    {
        $query = Anggota::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where(
                    'kode_anggota',
                    'like',
                    "%{$this->search}%"
                )->orWhere(
                    'nama_lengkap',
                    'like',
                    "%{$this->search}%"
                )->orWhere(
                    'kelas',
                    'like',
                    "%{$this->search}%"
                )->orWhere(
                    'no_telp',
                    'like',
                    "%{$this->search}%"
                );
            });
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
            'anggota' => $query->paginate(30)
        ];
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-6">
            <button onclick="openTambahModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                + Tambah Anggota
            </button>

            <input wire:model.live.debounce.500ms="search" type="text" placeholder="Cari kode, nama, kelas atau no telp..." class="border rounded-lg px-4 py-2 w-96">
    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th wire:click="sort('kode_anggota')" class="cursor-pointer px-4 py-3">
                        Kode
                        @if($sortField !== 'kode_anggota')
                            ↕
                        @elseif($sortDirection === 'asc')
                            ↑
                        @else
                            ↓
                        @endif
                    </th>

                    <th
                        wire:click="sort('nama_lengkap')"
                        class="cursor-pointer px-4 py-3">
                        Nama
                        @if($sortField !== 'nama_lengkap')
                            ↕
                        @elseif($sortDirection === 'asc')
                            ↑
                        @else
                            ↓
                        @endif

                    </th>

                    <th class="px-4 py-3">
                        Kelas
                    </th>

                    <th class="px-4 py-3">
                        Jabatan
                    </th>

                    <th class="px-4 py-3">
                        Email
                    </th>

                    <th class="px-4 py-3">
                        No Telp
                    </th>

                    <th class="px-4 py-3">
                        Status
                    </th>

                    <th class="px-4 py-3">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($anggota as $item)

                    <tr class="border-t">

                        <td class="px-4 py-3">
                            {{ $item->kode_anggota }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->nama_lengkap }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->kelas }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->jabatan }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->email }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->no_telp }}
                        </td>
                        
                        <td class="px-4 py-3">
                            @if($item->status == 'Aktif')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <button
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded"

                                data-id="{{ $item->id }}"
                                data-kode="{{ $item->kode_anggota }}"
                                data-nama="{{ $item->nama_lengkap }}"
                                data-jabatan="{{ $item->jabatan }}"
                                data-kelas="{{ $item->kelas }}"
                                data-email="{{ $item->email }}"
                                data-telp="{{ $item->no_telp }}"

                                onclick="openEditModal(this)"
                            >
                                Edit
                            </button>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-10 text-slate-500">

                            Belum ada data

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $anggota->links() }}
    </div>
</div>