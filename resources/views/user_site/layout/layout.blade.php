<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Halaman Utama') | NTISSB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo_syarikat.png') }}">
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col font-sans">

    {{-- HEADER --}}
    <header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-md border-b border-gray-200 z-50 flex justify-between items-center px-8 py-2 shadow-sm">
        <a href="{{ route('user_site.permohonan.index') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo_syarikat.png') }}" alt="Company Logo" class="w-10 h-10 object-contain drop-shadow-sm group-hover:scale-105 transition-transform">
            <span class="text-xs font-bold text-blue-700 leading-tight uppercase tracking-tighter">
                NT Image Supply & Services<br><span class="text-gray-500">SDN BHD</span>
            </span>
        </a>

        <button 
            data-modal-open="profileModal"
            class="flex items-center gap-3 px-3 py-1.5 bg-white border border-gray-200 rounded-full
                shadow-sm hover:shadow-md hover:border-blue-300 hover:bg-blue-50 transition-all duration-200
                cursor-pointer select-none group w-[220px] justify-between">
            
            <div class="w-8 h-8 rounded-full bg-blue-100 overflow-hidden flex-shrink-0 border border-blue-200 shadow-inner">
                <img src="{{ asset($user->gambar_profil ?? 'images/profile_picture/default-profile.png') }}" alt="Profile" class="w-full h-full object-cover">
            </div>

            <span class="font-bold text-gray-600 text-[11px] truncate group-hover:text-blue-700 transition-colors duration-200 flex-1 px-2 text-right uppercase tracking-wider">
                {{ $user->nama ?? 'Tiada Nama' }}
            </span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
    </header>

    {{-- BODY LAYOUT --}}
    <div class="flex flex-1 pt-[64px]">

        {{-- SIDEBAR --}}
        <nav class="sticky top-[64px] w-64 bg-white border-r border-gray-200 shadow-[2px_0_5px_rgba(0,0,0,0.02)] p-4 space-y-2 h-[calc(100vh-64px)] overflow-y-auto">
            @php
                $menu = [
                    ['name' => 'Halaman Utama', 'route' => 'user_site.permohonan.index', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['name' => 'Status Permohonan', 'route' => 'user_site.status_permohonan', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['name' => 'Status Perjalanan', 'route' => 'user_site.status_perjalanan', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7'],
                    ['name' => 'Rekod Permohonan', 'route' => 'user_site.rekod_permohonan', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp

            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}" 
                    class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 group
                        @if(request()->routeIs($item['route'])) 
                            bg-blue-600 text-white shadow-lg shadow-blue-200 font-bold
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

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <main class="flex-1 p-8 overflow-y-auto bg-gray-50 pb-[80px]">
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer class="fixed bottom-0 left-64 right-0 bg-white/80 backdrop-blur-md border-t border-gray-100 text-center py-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] z-10">
                © {{ date('Y') }} NTISSB Vehicle Management System • Professional Edition
            </footer>
        </div>
    </div>

    {{-- PROFILE MODAL --}}
    <div id="profileModal" data-modal 
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] flex items-center justify-center p-4">

        <div data-modal-card id="profileCard" 
            class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
            
            {{-- Modal Header/Cover --}}
            <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>

            <button data-modal-close 
                class="absolute top-4 right-4 text-white hover:rotate-90 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="px-8 pb-10">
                {{-- Avatar --}}
                <div class="relative -mt-12 flex justify-center mb-6">
                    <div class="w-24 h-24 rounded-3xl bg-white p-1.5 shadow-xl rotate-3 group hover:rotate-0 transition-transform duration-500">
                        <img src="{{ asset($user->gambar_profil ?? 'images/profile_picture/default-profile.png') }}" 
                            alt="Profile" class="w-full h-full object-cover rounded-[1.25rem]">
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">{{ $user->nama ?? 'Tiada Nama' }}</h3>
                    <p class="text-blue-600 font-bold text-xs uppercase tracking-widest mt-1">{{ $user->jawatan ?? 'Tiada Jawatan' }}</p>
                </div>

                <div class="space-y-3 bg-gray-50 p-5 rounded-2xl border border-gray-100 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase">ID Pekerja</span>
                        <span class="text-sm font-bold text-gray-700">{{ $user->id_pekerja ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase">Telefon</span>
                        <span class="text-sm font-bold text-gray-700">{{ $user->no_tel ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase">Email</span>
                        <span class="text-sm font-bold text-gray-700 truncate ml-4">{{ $user->email ?? '-' }}</span>
                    </div>
                </div>

                <a href="{{ route('logout') }}" 
                    class="flex items-center justify-center gap-2 w-full bg-red-50 text-red-600 py-4 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Keluar Sistem
                </a>
            </div>
        </div>
    </div>

</body>
</html>