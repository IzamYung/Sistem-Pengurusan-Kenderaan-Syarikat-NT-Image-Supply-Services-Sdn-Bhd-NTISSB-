<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Halaman Utama')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/logo_syarikat.png') }}">
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-sm border-b border-gray-200 z-50 flex justify-between items-center px-8 py-2 shadow-sm">
        <a href="{{ route('admin_site.halaman_utama') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo_syarikat.png') }}" alt="Company Logo" class="w-10 h-10 object-contain drop-shadow-sm">
            <span class="text-sm font-semibold text-blue-600 leading-tight">
                NT Image Supply & Services<br>SDN BHD
            </span>
        </a>

        <button 
            data-modal-open="profileModal"
            class="flex items-center gap-3 px-4 py-2 bg-white border border-gray-200 rounded-full
                shadow-sm hover:shadow-md hover:bg-blue-50 transition-all duration-200
                cursor-pointer select-none group w-[200px] justify-start">
            
            <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden flex-shrink-0 shadow-sm">
                {{-- future: <img src="{{ asset('images/profile.jpg') }}" alt="Profile" class="w-full h-full object-cover"> --}}
            </div>

            <span class="font-medium text-gray-700 text-sm truncate group-hover:text-blue-600 transition-colors duration-200 flex-1 text-center">
                {{ $user->nama ?? 'Tiada Nama' }}
            </span>
        </button>
    </header>

    {{-- BODY LAYOUT --}}
    <div class="flex flex-1 pt-[64px]">

        {{-- SIDEBAR --}}
        <nav class="sticky top-[64px] w-64 bg-white/95 backdrop-blur-sm border-r border-gray-100 shadow-sm p-3 space-y-1 h-[calc(100vh-64px)] overflow-y-auto">
            @php
                $menu = [
                    ['name' => 'Halaman Utama', 'route' => 'admin_site.halaman_utama'],
                    ['name' => 'Status Perjalanan', 'route' => 'admin_site.status_perjalanan'],
                    ['name' => 'Rekod Permohonan', 'route' => 'admin_site.rekod_permohonan'],
                    ['name' => 'Senarai Kenderaan', 'route' => 'admin_site.senarai_kenderaan'],
                    ['name' => 'Kerosakan Kenderaan', 'route' => 'admin_site.kerosakkan_kenderaan'],
                    ['name' => 'Senarai Pengguna', 'route' => 'admin_site.senarai_pengguna'],
                ];
            @endphp

            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}" 
                    class="block py-2 px-4 rounded-lg transition-all duration-200
                        text-gray-700 hover:text-blue-600 hover:bg-blue-50
                        @if(request()->routeIs($item['route'])) 
                            bg-blue-100 text-blue-700 font-semibold border-l-4 border-blue-500 
                        @endif">
                    {{ $item['name'] }}
                </a>
            @endforeach
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-gray-200 text-center py-3 text-sm text-gray-500 shadow-inner">
                © {{ date('Y') }} NTISSB Vehicle Management System
            </footer>
        </div>
    </div>

    {{-- PROFILE MODAL --}}
    <div id="profileModal" data-modal class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-[60] flex items-center justify-center">
        <div data-modal-card id="profileCard" class="relative bg-white rounded-2xl shadow-xl w-[90%] max-w-md p-6 transform transition-all duration-200 scale-95 opacity-0 border border-gray-100">
            <button data-modal-close class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center border-b border-gray-100 pb-2">Profil Pengguna</h3>
            @php $user = $user ?? Auth::user(); @endphp
            <div class="text-center">
                <p class="text-gray-600">{{ $user->nama ?? 'Tiada Nama' }}</p>
                <p class="text-gray-400 text-sm">{{ $user->email ?? 'Tiada Email' }}</p>
            </div>
        </div>
    </div>

</body>
</html>
