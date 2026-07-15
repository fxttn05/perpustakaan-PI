@extends('layout')
@section('content')
<div class="min-h-screen">
    <div class="bg-slate-100 py-6 px-10">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                Laporan
            </h1>
            <p class="text-slate-500">
                Selamat datang di sistem perpustakaan
            </p>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500 ">
                            Denda Belum Lunas
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-orange-600">
                            {{ $dendaBelumLunas }}
                        </h2>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-orange-100">

                        💸

                    </div>

                </div>

            </div>

            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Total Transaksi
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-indigo-600">
                            {{ $transaksiPinjam }}
                        </h2>

                    </div>

                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-indigo-100">

                        📑

                    </div>

                </div>

            </div>

            <!-- Total Buku -->
            <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">
                            Total Buku
                        </p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-800">
                            {{ number_format($totalBuku) }}
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
                            {{ number_format($totalAnggota) }}
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
                            {{ number_format($bukuDipinjam) }}
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
                            Rp
                            {{ number_format($totalDenda,0,',','.') }}
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

        <div class="grid grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded-xl shadow">
                <div class="border-b px-5 py-4">
                    <h2 class="font-semibold text-lg">
                        Anggota Teraktif
                    </h2>
                </div>

                <table class="w-full text-sm">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="px-4 py-3 text-left">
                                Kode
                            </th>

                            <th class="px-4 py-3 text-left">
                                Nama
                            </th>

                            <th class="px-4 py-3">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($anggotaTerbaru as $item)

                            <tr class="border-t">

                                <td class="px-4 py-3">
                                    {{ $item->kode_anggota }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $item->nama_lengkap }}
                                </td>

                                <td class="px-4 py-3 text-center font-bold">
                                    {{ $item->total_pinjam }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
            <div class="bg-white rounded-xl shadow">

                <div class="border-b px-5 py-4">

                    <h2 class="font-semibold text-lg">

                        Buku Paling Dipinjam

                    </h2>

                </div>

                <table class="w-full text-sm">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="px-4 py-3 text-left">
                                Kode
                            </th>

                            <th class="px-4 py-3 text-left">
                                Judul
                            </th>

                            <th class="px-4 py-3">
                                Dipinjam
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($bukuPopuler as $item)

                            <tr class="border-t">

                                <td class="px-4 py-3">

                                    {{ $item->kode_buku }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ $item->judul_buku }}

                                </td>

                                <td class="px-4 py-3 text-center font-bold">

                                    {{ $item->details_count }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow">

                <div class="border-b px-5 py-4">

                    <h2 class="font-semibold text-lg">

                        Peminjaman Terbaru

                    </h2>

                </div>

                <table class="w-full text-sm">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="px-4 py-3">
                                ID
                            </th>

                            <th class="px-4 py-3">
                                Nama
                            </th>

                            <th class="px-4 py-3">
                                Tanggal
                            </th>

                            <th class="px-4 py-3">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($peminjamanTerbaru as $item)

                            <tr class="border-t">

                                <td class="px-4 py-3">

                                    {{ $item->id_peminjaman }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ $item->anggota->nama_lengkap }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ $item->status }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
            <div class="bg-white rounded-xl shadow">

                <div class="border-b px-5 py-4">

                    <h2 class="font-semibold text-lg">

                        Denda Terbesar

                    </h2>

                </div>

                <table class="w-full text-sm">

                    <thead class="bg-slate-100">

                        <tr>

                            <th class="px-4 py-3">
                                Nama
                            </th>

                            <th class="px-4 py-3">
                                Buku
                            </th>

                            <th class="px-4 py-3">
                                Nominal
                            </th>

                            <th class="px-4 py-3">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($dendaTerbaru as $item)

                            <tr class="border-t">

                                <td class="px-4 py-3">

                                    {{ $item->detail->peminjaman->anggota->nama_lengkap }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ $item->detail->buku->judul_buku }}

                                </td>

                                <td class="px-4 py-3 font-bold text-red-600">

                                    Rp
                                    {{ number_format($item->nominal,0,',','.') }}

                                </td>

                                <td class="px-4 py-3">

                                    {{ $item->status }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>

        <!-- Charts -->
        <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">

            <!-- Line Chart -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="mb-5 text-lg font-semibold text-slate-700">
                    Statistik Peminjaman Buku
                </h2>

                <canvas id="loanChart"></canvas>
            </div>

            <!-- Doughnut Chart -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="mb-5 text-lg font-semibold text-slate-700">
                    Distribusi Kategori Buku
                </h2>

                <canvas id="categoryChart"></canvas>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Grafik Peminjaman
        new Chart(document.getElementById('loanChart'), {
            type: 'line',
            data: {
                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun'
                ],
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: [0, 0, 0, 0, 0, 0],
                    borderWidth: 3,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

        // Grafik Kategori Buku
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: [
                    'Buku Paket',
                    'Laporan PKL',
                    'Bacaan Bebas'
                ],
                datasets: [{
                    data: [0, 0, 0],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });

    </script>
</div>
@endsection
