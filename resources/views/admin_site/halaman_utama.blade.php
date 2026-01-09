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

                {{-- Speedometer Sebelum --}}
                <div class="col-span-2">
                    <p class="font-semibold text-gray-800 mb-2">
                        Speedometer Sebelum
                    </p>

                    @if($permohonan->speedometer_sebelum)
                        <img
                            src="{{ asset('storage/' . $permohonan->speedometer_sebelum) }}"
                            alt="Speedometer Sebelum"
                            class="cursor-pointer speedometer-preview rounded-lg border shadow"
                            style="max-height: 150px; width: auto;"
                            data-modal-open="modalSpeedometer"
                            data-modal-img="{{ asset('storage/' . $permohonan->speedometer_sebelum) }}"
                        >
                    @else
                        <p class="text-gray-500 italic">
                            Tiada gambar speedometer direkodkan.
                        </p>
                    @endif
                </div>

                {{-- Modal Speedometer --}}
                <div id="modalSpeedometer"
                    data-modal
                    class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">

                    <div data-modal-card
                        class="bg-white rounded-xl shadow-lg
                                transform scale-95 opacity-0 transition-all duration-200
                                p-5 max-w-3xl w-full">

                        {{-- IMAGE --}}
                        <div class="flex justify-center mb-4">
                            <img id="modalSpeedometerImg"
                                src=""
                                alt="Speedometer"
                                class="rounded-lg max-h-[80vh] w-auto">
                        </div>

                        {{-- CLOSE BUTTON --}}
                        <div class="flex justify-center mt-3">
                            <button data-modal-close class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Tutup</button>
                        </div>
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="col-span-2">
                    <p class="font-semibold text-gray-800 mb-2">Lampiran</p>

                    @if(!empty($permohonan->lampiran) && count($permohonan->lampiran) > 0)
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($permohonan->lampiran as $file)
                                <li>
                                    <a href="{{ asset('storage/' . $file) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:underline">
                                        {{ basename($file) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">Tiada lampiran</p>
                    @endif
                </div>

            </div>
        </div>

        {{-- Pemeriksaan --}}
        <h2 class="text-2xl font-bold mb-4 text-blue-800">Pemeriksaan</h2>

        <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200 mb-6">

            @php
                $sections = [
                                        'Bahagian Dalaman / Luaran' => [
                                            'badan_luaran' => 'Badan Luaran Kenderaan',
                                            'cermin_hadapan' => 'Cermin Hadapan / Kaca',
                                            'pengelap_cermin' => 'Pengelap Cermin',
                                            'lampu' => 'Lampu (Hadapan, Brek, Isyarat Belok)',
                                            'lampu_dalaman' => 'Lampu Dalaman',
                                            'penghawa_dingin' => 'Operasi Penghawa Dingin',
                                            'pemanasan' => 'Pemanasan',
                                            'lain_dalaman_luaran' => 'Lain-lain',
                                        ],
                                        'Bahagian Bawah Kenderaan' => [
                                            'brek' => 'Brek (Pad / Kasut Brek)',
                                            'salur_hos_brek' => 'Salur & Hos Brek',
                                            'sistem_stereng' => 'Sistem Stereng',
                                            'penyerap_kejutan' => 'Penyerap Kejutan & Topang',
                                            'sistem_ekzos' => 'Sistem Ekzos',
                                            'salur_hos_bahan_api' => 'Salur & Hos Bahan Api',
                                            'lain_bawah' => 'Lain-lain',
                                        ],
                                        'Bahagian Bawah Bonet' => [
                                            'minyak_enjin' => 'Minyak Enjin',
                                            'bendalir_brek' => 'Bendalir Brek',
                                            'bendalir_stereng' => 'Bendalir Stereng Kuasa',
                                            'bendalir_pencuci' => 'Bendalir Pencuci Cermin',
                                            'tali_sawat_hos' => 'Tali Sawat & Hos',
                                            'antibeku_penyejuk' => 'Anti-Beku / Penyejuk',
                                            'penapis_udara' => 'Penapis Udara',
                                            'penapis_kabin' => 'Penapis Kabin',
                                            'penapis_bahan_api' => 'Penapis Bahan Api',
                                            'palam_pencucuh' => 'Palam Pencucuh / Wayar',
                                            'bendalir_transmisi' => 'Bendalir Transmisi dan Perumah',
                                            'sistem_gantung' => 'Sistem Gantung / Ampaian',
                                        ],
                                        'Bateri' => [
                                            'caj_bateri' => 'Caj Bateri',
                                            'bendalir_bateri' => 'Bendalir Bateri',
                                            'kabel_sambungan' => 'Kabel & Sambungan',
                                        ],
                                        'Tayar - Kondisi & Tekanan' => [
                                            'bunga_kiri_hadapan' => 'Kedalaman Bunga (Kiri Hadapan)',
                                            'bunga_kiri_belakang' => 'Kedalaman Bunga (Kiri Belakang)',
                                            'bunga_kanan_hadapan' => 'Kedalaman Bunga (Kanan Hadapan)',
                                            'bunga_kanan_belakang' => 'Kedalaman Bunga (Kanan Belakang)',
                                            'udara_kiri_hadapan' => 'Tekanan Udara (Kiri Hadapan)',
                                            'udara_kiri_belakang' => 'Tekanan Udara (Kiri Belakang)',
                                            'udara_kanan_hadapan' => 'Tekanan Udara (Kanan Hadapan)',
                                            'udara_kanan_belakang' => 'Tekanan Udara (Kanan Belakang)',
                                        ],
                                        'Penyelenggaraan Tayar' => [
                                            'penjajaran' => 'Penjajaran (Alignment)',
                                            'pengimbangan' => 'Pengimbangan (Balancing)',
                                            'putaran' => 'Putaran (Rotation)',
                                            'tayar_baru' => 'Tayar Baru (Ganti)',
                                        ],
                                    ];
            @endphp

            @foreach($sections as $sectionName => $components)

            {{-- Section Title --}}
            <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 mb-4">
                <p class="text-blue-700 font-semibold text-lg">{{ $sectionName }}</p>
            </div>

            @php
                $adaMasalah = false;
            @endphp

            @foreach($components as $key => $label)

                @php
                    // Match using the KEY, not the label
                    $pmItem = $pemeriksaan->firstWhere('nama_komponen', $key);
                    $status = $pmItem->status ?? null;
                    $ulasan = $pmItem->ulasan ?? '-';

                    if ($status == 2 || $status == 3) {
                        $adaMasalah = true;
                    }
                @endphp

                @if($status == 2 || $status == 3)
                    <div class="border border-gray-300 rounded-lg p-4 mb-4 bg-white shadow-sm">

                        <p class="font-semibold text-gray-800 mb-2">{{ $label }}</p>

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

                        <div class="mt-3">
                            <label class="block font-semibold mb-1">Ulasan</label>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $ulasan }}
                            </p>
                        </div>

                    </div>
                @endif

            @endforeach

            {{-- ✅ FALLBACK IF NO ISSUE --}}
            @if(!$adaMasalah)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-700 italic">
                        Tiada sebarang masalah dikesan bagi bahagian ini.
                    </p>
                </div>
            @endif

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

            {{-- ❌ TIDAK LULUS & KEROSAKAN --}}
            <form action="{{ route('admin_site.permohonan.tidak_lulus_rosak', $permohonan->id_permohonan) }}" method="POST">
                @csrf
                <button class="px-5 py-2 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700">
                    Tidak Lulus & Kerosakan
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
