@extends('user_site.layout.layout')

@section('title', 'Halaman Utama')

@section('content')

@if(isset($page) && $page === 'borang')
    {{-- BORANG PERMOHONAN --}}
    <div class="max-w-3xl mx-auto mt-10 mb-20 bg-white rounded-2xl shadow p-8">
        <h2 class="text-3xl font-bold mb-6 text-[#1e3a8a] text-center">Borang Permohonan Kenderaan</h2>

        <form method="POST" action="{{ route('user_site.permohonan.store') }}"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="bg-blue-50 p-4 rounded-lg border">
                <p><b>No. Pendaftaran:</b> {{ $kenderaan->no_pendaftaran ?? '-' }}</p>
                <p><b>Model:</b> {{ $kenderaan->model ?? '-' }}</p>
                <p><b>Pemohon:</b> {{ $user->nama ?? '-' }}</p>
            </div>

            <input type="hidden" name="no_pendaftaran" value="{{ $kenderaan->no_pendaftaran ?? '' }}">

            <div>
                <label class="font-semibold">Tarikh & Masa Pelepasan</label>
                <input type="datetime-local" name="tarikh_pelepasan" required
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="font-semibold">Lokasi / Tujuan</label>
                <input type="text" name="lokasi" required
                       class="w-full border rounded-lg px-3 py-2 mt-1" />
            </div>

            <div>
                <label class="font-semibold">Bilangan Penumpang</label>
                <input type="number" min="1" name="bil_penumpang" required
                       class="w-full border rounded-lg px-3 py-2 mt-1" />
            </div>

            <div>
                <label class="font-semibold">Kod Projek</label>
                <input type="text" name="kod_projek" required
                       class="w-full border rounded-lg px-3 py-2 mt-1" />
            </div>

            <div>
                <label class="font-semibold">Hak Milik</label>
                <input type="text" name="hak_milik" required
                       class="w-full border rounded-lg px-3 py-2 mt-1" />
            </div>

            <div>
                <label class="font-semibold">Lampiran</label>
                <input type="file" name="lampiran[]" multiple
                       class="w-full border rounded-lg px-3 py-2 mt-1" />
            </div>

            <button class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                Hantar Permohonan
            </button>
        </form>
    </div>

@else
    {{-- SENARAI KENDERAAN --}}
    <div class="max-w-5xl mx-auto mt-10">
        <h2 class="text-3xl font-bold text-center mb-6 text-[#1e3a8a]">Senarai Kenderaan</h2>

        {{-- FILTER + SEARCH --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
            <select name="jenama" class="border rounded-lg px-3 py-2">
                <option value="">Semua Jenama</option>
                @foreach($jenamaList as $brand)
                    <option value="{{ $brand }}" {{ strtolower(request('jenama')) == strtolower($brand) ? 'selected' : '' }}>
                        {{ ucfirst($brand) }}
                    </option>
                @endforeach
            </select>

            <input type="number"
                   name="kapasiti"
                   placeholder="Kapasiti"
                   min="1"
                   value="{{ request('kapasiti') ?? '' }}"
                   class="border rounded-lg px-3 py-2" />

            <input type="text"
                   id="searchKenderaan"
                   name="search"
                   placeholder="Cari model / no pendaftaran…"
                   value="{{ request('search') }}"
                   class="border px-3 py-2 rounded-lg" />
        </form>

        {{-- LIST --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="vehicleList">
            @forelse ($kenderaan ?? [] as $car)
                <a href="{{ route('user_site.permohonan.borang', ['no_pendaftaran' => $car->no_pendaftaran]) }}"
                   class="vehicle-card block bg-white p-4 rounded-xl shadow hover:shadow-lg transition"
                   data-name="{{ strtolower($car->model) }}"
                   data-no_pendaftaran="{{ strtolower($car->no_pendaftaran) }}"
                   data-jenama="{{ strtolower($car->jenama) }}"
                   data-kapasiti="{{ intval($car->kapasiti) }}"
                   data-kategori="{{ strtolower($car->jenis_kenderaan) }}">
                    <div class="flex gap-4">
                        <img src="{{ asset($car->gambar_kenderaan) }}"
                        class="w-32 h-20 object-cover rounded-lg border" />

                        <div>
                            <p class="text-lg font-bold text-[#1e3a8a]">{{ $car->model }}</p>
                            <p class="text-gray-600">{{ $car->no_pendaftaran }}</p>
                            <p class="text-sm text-gray-500">{{ $car->jenis_kenderaan }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-center text-gray-500 mt-5">Tiada kenderaan ditemui.</p>
            @endforelse
        </div>

        <p id="noMatchVehicle" class="hidden text-center text-gray-500 mt-5">Tiada padanan ditemui.</p>
        <p id="noVehicle" class="hidden text-center text-gray-500 mt-5">Tiada kenderaan ditemui.</p>
    </div>
@endif

@endsection
