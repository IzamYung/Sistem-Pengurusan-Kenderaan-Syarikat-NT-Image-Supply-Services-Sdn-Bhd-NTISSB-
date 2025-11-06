<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Halaman Utama')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50 flex justify-between items-center px-6 py-3 shadow-sm">
        <a href="{{ route('admin_site.halaman_utama') }}" class="text-xl font-semibold text-blue-600">
            NT Image Supply & Services SDN BHD
        </a>
        <button 
            data-modal-open="profileModal"
            class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
            <span>Profil Saya</span>
        </button>
    </header>

    <div class="flex flex-1 pt-[64px]">
        {{-- Sidebar --}}
        <nav class="sticky top-[64px] w-64 bg-white border-r border-gray-200 p-2 space-y-1 h-[calc(100vh-64px)] overflow-y-auto">

            @php
                $menu = [
                    ['name' => 'Halaman Utama', 'route' => 'admin_site.halaman_utama'],
                    ['name' => 'Status Perjalanan', 'route' => 'admin_site.status_perjalanan'],
                    ['name' => 'Rekod Permohonan', 'route' => 'admin_site.rekod_permohonan'],
                    ['name' => 'Senarai Kenderaan', 'route' => 'admin_site.senarai_kenderaan'],
                    ['name' => 'Kerosakan Kenderaan', 'route' => 'admin_site.kerosakkan_kenderaan'],
                    ['name' => 'Tambah Pengguna', 'route' => 'admin_site.tambah_pengguna'],
                ];
            @endphp

            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}" 
                   class="block px-5 py-2 rounded-lg transition-all 
                   @if(request()->routeIs($item['route'])) 
                        bg-blue-100 text-blue-700 font-medium border-l-4 border-blue-500 
                   @else 
                        hover:bg-blue-50 hover:text-blue-600 
                   @endif">
                   {{ $item['name'] }}
                </a>
            @endforeach
        </nav>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-y-auto">
            <main class="flex-1 p-6">
                @yield('content')
            </main>
            <footer class="bg-white border-t border-gray-200 text-center py-3 text-sm text-gray-500">
                © {{ date('Y') }} NTISSB Vehicle Management System
            </footer>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" data-modal 
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center">
        
        <div data-modal-card id="profileCard" 
            class="bg-white rounded-2xl shadow-lg w-[90%] max-w-md p-6 transform transition-all duration-200 scale-95 opacity-0">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Profil Pengguna</h3>
            @php $user = $user ?? Auth::user(); @endphp
            <div class="text-sm text-gray-700 mb-6">
                <p><strong>Nama :</strong> {{ $user->nama ?? 'Tiada Nama' }}</p>
                <p><strong>ID Pekerja :</strong> {{ $user->id_pekerja ?? 'Tiada ID' }}</p>
                <p><strong>Jawatan :</strong> {{ $user->jawatan ?? 'Tiada Jawatan' }}</p>
                <p><strong>No. Telefon :</strong> {{ $user->no_tel ?? 'Tiada No. Telefon' }}</p>
            </div>

            <div class="flex justify-center gap-3">
                <a href="{{ route('logout') }}" 
                   class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Log Keluar</a>
                <button data-modal-close 
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">Tutup</button>
            </div>
        </div>
    </div>
</body>
</html>
