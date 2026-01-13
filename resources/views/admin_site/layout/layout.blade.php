<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | NTISSB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo_syarikat.png') }}">
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col font-sans">

    <header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md border-b border-gray-200 z-50 flex justify-between items-center px-8 py-2 shadow-sm">
        <a href="{{ route('admin_site.halaman_utama') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo_syarikat.png') }}" alt="Company Logo" class="w-10 h-10 object-contain drop-shadow-sm group-hover:scale-105 transition-transform">
            <span class="text-xs font-bold text-blue-700 leading-tight uppercase tracking-tighter">
                NT Image Supply & Services<br><span class="text-gray-500 text-[10px]">SDN BHD</span>
            </span>
        </a>

        <button data-modal-open="profileModal" 
            class="flex items-center gap-3 px-3 py-1.5 bg-white border border-gray-200 rounded-full shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 cursor-pointer select-none group w-[220px] justify-between">
            <div class="w-8 h-8 rounded-full bg-blue-100 overflow-hidden flex-shrink-0 border border-blue-200 shadow-inner">
                <img src="{{ asset($user->gambar_profil ?? 'images/profile_picture/default-profile.png') }}" alt="Profile" class="w-full h-full object-cover">
            </div>
            <span class="font-bold text-gray-600 text-[11px] truncate group-hover:text-blue-700 transition-colors duration-200 flex-1 px-2 text-right uppercase tracking-wider">
                {{ $user->nama ?? 'Admin' }}
            </span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </header>

    <div class="flex flex-1 pt-[64px]">
        <nav class="sticky top-[64px] w-64 bg-white border-r border-gray-200 shadow-[2px_0_5px_rgba(0,0,0,0.02)] p-4 space-y-2 h-[calc(100vh-64px)] overflow-y-auto">
            @php
                $menu = [
                    ['name' => 'Halaman Utama', 'route' => 'admin_site.halaman_utama', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['name' => 'Rekod Permohonan', 'route' => 'admin_site.rekod_permohonan', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['name' => 'Senarai Kenderaan', 'route' => 'admin_site.senarai_kenderaan', 'icon' => 'M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0zm10 0a2 2 0 1 0 4 0 2 2 0 0 0-4 0zm-9-4h8m-8-5h5a4 4 0 0 1 3.8 2.8l.7 2.2H3.5l.7-2.2A4 4 0 0 1 6 8z'],
                    ['name' => 'Kerosakan Kenderaan', 'route' => 'admin_site.kerosakkan_kenderaan', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                    ['name' => 'Senarai Pengguna', 'route' => 'admin_site.senarai_pengguna', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ];
            @endphp

            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}" 
                    class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 group
                    @if(request()->routeIs($item['route'])) 
                        bg-[#1e3a8a] text-white shadow-lg shadow-blue-100 font-bold
                    @else 
                        text-gray-500 hover:text-blue-600 hover:bg-blue-50
                    @endif">
                    <svg class="w-5 h-5 @if(request()->routeIs($item['route'])) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                    </svg>
                    <span class="text-sm tracking-wide">{{ $item['name'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            <main class="flex-1 p-8 overflow-y-auto bg-gray-50 pb-[80px]">
                @yield('content')
            </main>

            <footer class="fixed bottom-0 left-64 right-0 bg-white/80 backdrop-blur-md border-t border-gray-100 text-center py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] z-10">
                © {{ date('Y') }} NTISSB Admin Portal • Managed System
            </footer>
        </div>
    </div>

    <div id="profileModal" data-modal class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
        <div data-modal-card id="profileCard" class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
            <div class="h-24 bg-gradient-to-r from-[#1e3a8a] to-blue-500"></div>

            <button data-modal-close class="absolute top-4 right-4 text-white hover:rotate-90 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="px-8 pb-10">
                <div class="relative -mt-12 flex justify-center mb-6">
                    <div class="w-24 h-24 rounded-3xl bg-white p-1.5 shadow-xl rotate-3">
                        <img src="{{ asset($user->gambar_profil ?? 'images/profile_picture/default-profile.png') }}" alt="Profile" class="w-full h-full object-cover rounded-[1.25rem]">
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">{{ $user->nama ?? 'Administrator' }}</h3>
                    <p class="text-blue-600 font-bold text-xs uppercase tracking-widest mt-1">Sistem Pentadbir</p>
                </div>

                <div class="space-y-3 bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-8 text-sm">
                    <p class="flex justify-between"><span class="font-black text-gray-400 uppercase text-[10px]">ID Pekerja :</span> <strong>{{ $user->id_pekerja ?? '-' }}</strong></p>
                    <p class="flex justify-between"><span class="font-black text-gray-400 uppercase text-[10px]">Jawatan :</span> <strong>{{ $user->jawatan ?? '-' }}</strong></p>
                    <p class="flex justify-between"><span class="font-black text-gray-400 uppercase text-[10px]">Email :</span> <strong class="truncate ml-4">{{ $user->email ?? '-' }}</strong></p>
                </div>

                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full bg-red-50 text-red-600 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-red-600 hover:text-white transition-all duration-300">
                    Log Keluar Pentadbir
                </a>
            </div>
        </div>
    </div>

</body>
</html>