@extends('layout')
@section('content')
<div class="min-h-screen">
    <div class="bg-slate-100 py-6 px-10">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                Dashboard
            </h1>
            <p class="text-slate-500">
                Selamat datang di sistem perpustakaan
            </p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            <!-- Total Buku -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">
                            Total Buku
                        </p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ $totalBuku }}
                        </h2>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100">
                        <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.483 9.246 5 7.5 5A4.5 4.5 0 003 9.5V19a4 4 0 014-4h10a4 4 0 014 4V9.5A4.5 4.5 0 0016.5 5c-1.746 0-3.332.483-4.5 1.253z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Anggota -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">
                            Total Anggota
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ $totalAnggota }}
                        </h2>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-100">
                        <svg class="h-7 w-7 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5V4H2v16h5m10 0v-4a4 4 0 00-8 0v4m8 0H9m8 0h-8m4-8a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>

                </div>
            </div>

            <!-- Buku Dipinjam -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Buku Dipinjam
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ $bukuDipinjam }}
                        </h2>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-amber-100">
                        <svg class="h-7 w-7 text-amber-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10m-5 5h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                </div>
            </div>

            <!-- Total Denda -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Total Denda
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-slate-800">
                            Rp {{ number_format($totalDenda,0,',','.') }}
                        </h2>
                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-100">
                        <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 1.343-3 3v1h6v-1c0-1.657-1.343-3-3-3zm0 0V5m0 14v-3" />
                        </svg>
                    </div>

                </div>
            </div>

        </div>

        <div class="grid grid-cols-3 gap-4 mt-8">
            <a href="{{ route('anggota') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 text-center font-semibold shadow">
                Anggota
            </a>
        
            <a href="{{ route('buku') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 text-center font-semibold shadow">
                Buku
            </a>
        
            <a href="{{ route('peminjaman') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 text-center font-semibold shadow">
                Transaksi
            </a>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-xl bg-white shadow p-5">

                <h2 class="font-bold text-lg mb-4">
                Riwayat Peminjaman
                </h2>

                <table class="w-full text-sm">
                
                <thead class="bg-slate-100">
                
                <tr>
                <th class="py-2">Tanggal</th>
                <th>Buku</th>
                <th>Anggota</th>
                <th>Status</th>
                </tr>

                </thead>

                <tbody>
                
                @forelse($riwayatPinjam as $item)
                
                <tr class="border-t">
                
                <td>{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                
                <td>{{ $item->buku->judul_buku }}</td>
                
                <td>{{ $item->peminjaman->anggota->nama_lengkap }}</td>
                
                <td>{{ $item->status }}</td>
                
                </tr>

                @empty

                <tr>
                
                <td colspan="4" class="text-center py-6">
                Belum ada data.
                </td>

                </tr>

                @endforelse

                </tbody>

                </table>

            </div>

            <div class="rounded-xl bg-white shadow p-5">

                <h2 class="font-bold text-lg mb-4">
                Riwayat Pengembalian
                </h2>

                <table class="w-full text-sm">
                
                <thead class="bg-slate-100">
                
                <tr>
                <th class="py-2">Tanggal</th>
                <th>Buku</th>
                <th>Anggota</th>
                <th>Status</th>
                </tr>

                </thead>

                <tbody>
                
                @forelse($riwayatKembali as $item)
                
                <tr class="border-t">
                
                <td>{{ $item->updated_at->format('d M Y') }}</td>
                
                <td>{{ $item->buku->judul_buku }}</td>
                
                <td>{{ $item->peminjaman->anggota->nama_lengkap }}</td>
                
                <td>{{ $item->status }}</td>
                
                </tr>

                @empty

                <tr>
                
                <td colspan="4" class="text-center py-6">
                Belum ada data.
                </td>

                </tr>

                @endforelse

                </tbody>

                </table>

            </div>
        </div>

        <!-- Charts -->
        <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">

            <!-- Doughnut Chart -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="mb-5 text-lg font-semibold text-slate-700">
                    Distribusi Kategori Buku yang Dipinjam
                </h2>

                <canvas id="categoryChart"></canvas>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        
    const kategori = @json($kategori);
        
    new Chart(document.getElementById('categoryChart'),{
    
    type:'doughnut',
    
    data:{
    
    labels:kategori.map(e=>e.nama_kategori),
    
    datasets:[{
    
    data:kategori.map(e=>e.total)
    
    }]
    
    },
    
    options:{
    
    responsive:true,
    
    plugins:{
    
    legend:{
    position:'bottom'
    }
    
    }
    
    }
    
    });
    
    </script>
</div>
@endsection
