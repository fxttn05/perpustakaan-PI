<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Perpustakaan SMK Taruna Bhakti</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="relative bg-[#4692CC] after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-10 items-center justify-between">
                <div class="flex gap-3 text-white font-semibold">
                    <div class="flex shrink-0 items-center">
                        <img src="{{ asset('logo/SMK_Taruna_Bhakti_nobg.png') }}" alt="SMKTB logo" class="h-5 w-auto" />
                    </div>
                    Perpustakaan SMK Taruna Bhakti
                </div>
                <div class="mr-3">
                    <button type="button" class="text-white font-semibold bg-red-700 px-3 py-1 rounded-lg">
                      Logout
                    </button>                  
                </div>
            </div>
        </div>
    </nav>
    <nav class="relative bg-[#275471] after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <!-- Mobile menu button-->
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </button>
                </div>

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="hidden sm:block">
                        <div class="flex space-x-4">                   
                            <a href="{{route('home')}}" aria-current="{{request()->routeIs('home') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('home') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}"> 
                                Dashboard
                            </a>
                        
                            <a href="{{route('anggota')}}" aria-current="{{request()->routeIs('anggota') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('anggota') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                Anggota
                            </a>
                        
                            <a href="{{route('buku')}}" aria-current="{{request()->routeIs('buku') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('buku') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                Buku
                            </a>
                        
                            <a href="{{route('peminjaman')}}" aria-current="{{request()->routeIs('peminjaman') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('peminjaman') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                Peminjaman
                            </a>
                        
                            <a href="{{route('pengembalian')}}" aria-current="{{request()->routeIs('pengembalian') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('pengembalian') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                Pengembalian
                            </a>
                        
                            <a href="{{route('denda')}}" aria-current="{{request()->routeIs('denda') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('denda') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                Denda
                            </a>
                        
                            <a href="{{route('laporan')}}" aria-current="{{request()->routeIs('laporan') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('laporan') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                Laporan
                            </a>
                        
                            <a href="{{route('profile')}}" aria-current="{{request()->routeIs('profile') ? 'page' : 'false'}}"
                               class="rounded-md px-3 py-2 text-sm font-medium {{request()->routeIs('profile') ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">
                                profile
                            </a>
                        
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
                <a href="#" aria-current="page" class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
            </div>
        </el-disclosure>
    </nav>

    <!--App Main-->
    <main class="app-main">
        @yield('content')
    </main>

    <footer class="app-footer text-black text-center py-2">
        <p><a href="https://smktarunabhakti.sch.id" class="text-decoration-none text-black">SMK Taruna Bhakti Depok</a> | 2026</p>
    </footer>

</body>
</html>