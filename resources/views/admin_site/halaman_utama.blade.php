@extends('admin_site.layout.layout')

@section('title', 'Halaman Utama Admin')

@section('content')
<div class="max-w-5xl mx-auto mt-10 mb-20">

    {{-- ============================
         IF ADA PARAMETER id_permohonan → PAPAR MAKLUMAT PENUH
       ============================ --}}
    @if(request()->has('id_permohonan') && isset($permohonan))
        
        {{-- Tajuk --}}
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-900">
            Maklumat Permohonan
        </h1>

        {{-- Card Maklumat --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-10 border border-gray-200">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">
                Butiran Permohonan
            </h2>

            <div class="grid grid-cols-2 gap-4 text-gray-700">

                <p><span class="font-semibold">ID Pengguna:</span> {{ $permohonan->id_user }}</p>
                <p><span class="font-semibold">No Pendaftaran:</span> {{ $permohonan->no_pendaftaran }}</p>

                <p><span class="font-semibold">Tarikh Mohon:</span> {{ $permohonan->tarikh_mohon }}</p>
                <p><span class="font-semibold">Lokasi:</span> {{ $permohonan->lokasi }}</p>

                <p><span class="font-semibold">Bil Penumpang:</span> {{ $permohonan->bil_penumpang }}</p>
                <p><span class="font-semibold">Kod Projek:</span> {{ $permohonan->kod_projek }}</p>

                <p><span class="font-semibold">Hak Milik:</span> {{ $permohonan->hak_milik ?? '-' }}</p>
                <p><span class="font-semibold">Status Pengesahan:</span> {{ $permohonan->status_pengesahan }}</p>

                <p><span class="font-semibold">Speedometer Sebelum:</span> {{ $permohonan->speedometer_sebelum ?? '-' }}</p>
                <p><span class="font-semibold">Speedometer Selepas:</span> {{ $permohonan->speedometer_selepas ?? '-' }}</p>

            </div>
        </div>

        {{-- Pemeriksaan --}}
        <h2 class="text-2xl font-bold mb-4 text-blue-800">Pemeriksaan</h2>

        <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200 mb-6">

            @php
                $sections = [
                    'Bahagian Dalaman / Luaran' => [
                        'Badan Luaran Kenderaan',
                        'Cermin Hadapan / Kaca',
                        'Pengelap Cermin',
                        'Lampu (Hadapan, Brek, Isyarat Belok)',
                        'Lampu Dalaman',
                        'Operasi Penghawa Dingin',
                        'Pemanasan',
                        'Lain-lain (Dalaman/Luaran)',
                    ],

                    'Bahagian Bawah Kenderaan' => [
                        'Brek (Pad / Kasut Brek)',
                        'Salur & Hos Brek',
                        'Sistem Stereng',
                        'Penyerap Kejutan & Topang',
                        'Sistem Ekzos',
                        'Salur & Hos Bahan Api',
                        'Lain-lain (Bawah)',
                    ],
                ];
            @endphp

            @foreach($sections as $sectionName => $components)

                {{-- Section Title --}}
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 mb-4">
                    <p class="text-blue-700 font-semibold text-lg">{{ $sectionName }}</p>
                </div>

                @foreach($components as $label)

                    @php
                        $pmItem = $pemeriksaan->firstWhere('nama_komponen', $label);
                        $status = $pmItem->status ?? null;
                        $ulasan = $pmItem->ulasan ?? '-';
                    @endphp

                    {{-- Only show status 2 & 3 --}}
                    @if($status == 2 || $status == 3)

                        <div class="border border-gray-300 rounded-lg p-4 mb-4 bg-white shadow-sm">

                            {{-- Komponen --}}
                            <p class="font-semibold text-gray-800 mb-2">{{ $label }}</p>

                            {{-- Radio Buttons SAME DESIGN --}}
                            <div class="flex items-center gap-6 mb-3">

                                <label class="flex items-center gap-2">
                                    <input type="radio" disabled {{ $status == 1 ? 'checked' : '' }}>
                                    <span>Baik (1)</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="radio" disabled {{ $status == 2 ? 'checked' : '' }}>
                                    <span>Perlu Perhatian (2)</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="radio" disabled {{ $status == 3 ? 'checked' : '' }}>
                                    <span>Rosak / Tidak OK (3)</span>
                                </label>
                            </div>

                            {{-- Ulasan SAME LIKE FORM but PLAIN TEXT --}}
                            <div class="mt-3">
                                <label class="block font-semibold mb-1">Ulasan</label>
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $ulasan }}
                                </p>
                            </div>

                        </div>

                    @endif

                @endforeach

            @endforeach

        </div>

        {{-- BUTTON LULUS / TIDAK LULUS --}}
        <div class="flex justify-center gap-4 mt-6">
            <form action="{{ route('admin_site.permohonan.lulus', $permohonan->id_permohonan) }}" method="POST">
                @csrf
                <button class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                    Lulus
                </button>
            </form>

            <form action="{{ route('admin_site.permohonan.tidak_lulus', $permohonan->id_permohonan) }}" method="POST">
                @csrf
                <button class="px-5 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                    Tidak Lulus
                </button>
            </form>
        </div>

        {{-- Back --}}
        <div class="text-center mt-10">
            <a href="{{ route('admin_site.halaman_utama') }}"
               class="text-blue-700 hover:underline">
                ← Kembali ke Senarai Permohonan
            </a>
        </div>

    {{-- ============================
         ELSE → PAPAR SENARAI PERMOHONAN
       ============================ --}}
    @else

        <h1 class="text-3xl font-bold text-center mb-8 text-blue-900">
            Senarai Permohonan
        </h1>

        @foreach ($senarai as $item)
            <a href="{{ route('admin_site.halaman_utama', ['id_permohonan' => $item->id_permohonan]) }}">
                <div class="bg-white shadow-md rounded-xl p-5 mb-4 border hover:shadow-lg transition">

                    <div class="flex justify-between mb-3">

                        {{-- LEFT CONTENT --}}
                        <div>
                            <p class="font-semibold text-lg text-blue-900">
                                {{ $item->user->nama ?? $item->id_user }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Nombor Pendaftaran: 
                                <span class="font-medium">{{ $item->no_pendaftaran }}</span>
                            </p>
                            <p class="text-sm text-gray-600">
                                Model: 
                                <span class="font-medium">{{ $item->kenderaan->model ?? '-' }}</span>
                            </p>
                            <p class="text-sm text-gray-600">
                                Lokasi: 
                                <span class="font-medium">{{ $item->lokasi ?? '-' }}</span>
                            </p>
                        </div>

                        {{-- RIGHT CONTENT --}}
                        <div class="text-right text-sm text-gray-500">
                            <p>Tarikh Mohon:</p>
                            <p class="font-medium text-gray-700">
                                {{ $item->tarikh_mohon ?? '-' }}
                            </p>

                            <p class="mt-2">Tarikh Pelepasan:</p>
                            <p class="font-medium text-gray-700">
                                {{ $item->tarikh_pelepasan ? $item->tarikh_pelepasan->format('d/m/Y') : '-' }}
                            </p>
                        </div>

                    </div>

                </div>
            </a>

        @endforeach

    @endif

</div>
@endsection
