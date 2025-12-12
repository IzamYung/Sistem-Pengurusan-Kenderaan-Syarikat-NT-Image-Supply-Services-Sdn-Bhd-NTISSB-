@extends('user_site.layout.layout')

@section('title', 'Status Permohonan')

@section('content')
@if(isset($page) && $page === 'pemeriksaan')
    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">

            <!-- Header -->
            <div class="bg-blue-600 text-white text-center py-5">
                <h3 class="text-2xl font-semibold">Laporan Pemeriksaan Kenderaan</h3>
            </div>

            <div class="p-6">
                <form action="{{ route('user_site.permohonan.simpan_pemeriksaan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_permohonan" value="{{ $permohonan->id_permohonan }}">

                    {{-- Mileage --}}
                    <div class="mb-5">
                        <label for="mileage" class="block font-medium text-gray-700 mb-1">
                            Mileage Semasa
                        </label>

                        <input type="number"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('mileage') border-red-500 @enderror"
                            id="mileage"
                            name="mileage"
                            value="{{ old('mileage') }}"
                            required
                            min="0">

                        @error('mileage')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- TABLE WRAPPER -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="p-3 border-b text-left font-semibold">Item</th>
                                    <th colspan="3" class="p-3 border-b text-center font-semibold">Status</th>
                                </tr>
                                <tr class="bg-gray-50">
                                    <th class="p-2 border-b text-left">Bahagian</th>
                                    <th class="p-2 border-b text-center" title="Semak dan Sahkan">1</th>
                                    <th class="p-2 border-b text-center" title="Perlu Perhatian">2</th>
                                    <th class="p-2 border-b text-center" title="Perlu Tindakan Segera">3</th>
                                </tr>
                            </thead>

                            <tbody>

                                @php
                                    // 🌟 MASTER ARRAY - ALL SECTIONS + ITEMS
                                    $sections = [

                                        // 1. DALAMAN / LUARAN
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

                                        // 2. BAWAH KENDERAAN
                                        'Bahagian Bawah Kenderaan' => [
                                            'brek' => 'Brek (Pad / Kasut Brek)',
                                            'salur_hos_brek' => 'Salur & Hos Brek',
                                            'sistem_stereng' => 'Sistem Stereng',
                                            'penyerap_kejutan' => 'Penyerap Kejutan & Topang',
                                            'sistem_ekzos' => 'Sistem Ekzos',
                                            'salur_hos_bahan_api' => 'Salur & Hos Bahan Api',
                                            'lain_bawah' => 'Lain-lain',
                                        ],

                                        // 3. BAWAH BONET
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

                                        // 4. BATERI
                                        'Bateri' => [
                                            'caj_bateri' => 'Caj Bateri',
                                            'bendalir_bateri' => 'Bendalir Bateri',
                                            'kabel_sambungan' => 'Kabel & Sambungan',
                                        ],

                                        // 5. TAYAR
                                        'Tayar - Kedalaman Bunga Tayar' => [
                                            'bunga_kiri_hadapan' => 'Kiri Hadapan',
                                            'bunga_kiri_belakang' => 'Kiri Belakang',
                                            'bunga_kanan_hadapan' => 'Kanan Hadapan',
                                            'bunga_kanan_belakang' => 'Kanan Belakang',
                                        ],

                                        'Tayar - Corak Hausan / Kerosakan' => [
                                            'haus_kiri_hadapan' => 'Kiri Hadapan',
                                            'haus_kiri_belakang' => 'Kiri Belakang',
                                            'haus_kanan_hadapan' => 'Kanan Hadapan',
                                            'haus_kanan_belakang' => 'Kanan Belakang',
                                        ],

                                        'Tayar - Tekanan Udara' => [
                                            'udara_kiri_hadapan' => 'Kiri Hadapan',
                                            'udara_kiri_belakang' => 'Kiri Belakang',
                                            'udara_kanan_hadapan' => 'Kanan Hadapan',
                                            'udara_kanan_belakang' => 'Kanan Belakang',
                                        ],

                                        'Tayar - Semakan / Cadangan Selang OE' => [
                                            'penjajaran' => 'Penjajaran',
                                            'pengimbangan' => 'Pengimbangan',
                                            'putaran' => 'Putaran',
                                            'tayar_baru' => 'Tayar Baru (Ganti)',
                                        ],
                                    ];
                                @endphp

                                {{-- 🌟 UNIVERSAL LOOP  --}}
                                @foreach($sections as $sectionName => $items)
                                    <tr>
                                        <td colspan="4" class="bg-blue-50 text-blue-700 font-semibold p-2">
                                            {{ $sectionName }}
                                        </td>
                                    </tr>

                                    @foreach($items as $key => $label)
                                        <tr class="inspection-item border-b hover:bg-gray-50 transition" data-key="{{ $key }}">
                                            <td class="p-3 font-medium text-gray-800">
                                                {{ $label }}
                                            </td>

                                            @for($i = 1; $i <= 3; $i++)
                                                <td class="text-center p-2">
                                                    <input type="radio"
                                                        name="pemeriksaan[{{ $key }}][status]"
                                                        value="{{ $i }}"
                                                        required
                                                        class="status-radio cursor-pointer"
                                                        data-key="{{ $key }}"
                                                        data-status="{{ $i }}"
                                                        {{ old("pemeriksaan.$key.status") == $i ? 'checked' : '' }}>
                                                </td>
                                            @endfor
                                        </tr>

                                        {{-- ULASAN FIELD --}}
                                        <tr id="ulasan-row-{{ $key }}" class="hidden bg-gray-50 border-b">
                                            <td colspan="4" class="p-3">
                                                <label class="font-medium text-gray-700 block mb-1">
                                                    Penjelasan / Ulasan
                                                </label>

                                                <textarea
                                                    name="pemeriksaan[{{ $key }}][ulasan]"
                                                    id="ulasan-{{ $key }}"
                                                    rows="2"
                                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 overflow-auto resize-none @error("pemeriksaan.$key.ulasan") border-red-500 @enderror">{{ old("pemeriksaan.$key.ulasan") }}</textarea>

                                                @error("pemeriksaan.$key.ulasan")
                                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg shadow-md font-semibold transition">
                            Hantar Pemeriksaan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@else
    <div class="max-w-5xl mx-auto mt-10 mb-20">
        <h1 class="text-3xl font-bold text-center mb-6 text-[#1e3a8a]">Status Permohonan</h1>

        <table class="w-full border-collapse shadow-md rounded-xl overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border border-gray-300 px-4 py-3 text-left">Perkara</th>
                    <th class="border border-gray-300 px-4 py-3 w-40 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permohonan ?? [] as $item)
                    @php
                        $status_raw = $item->status_pengesahan;
                        $status = strtolower($status_raw);
                        $pemeriksaan_url = route('user_site.permohonan.pemeriksaan', $item->id_permohonan);

                        if ($status === 'menunggu kelulusan' || $status === 'menunggu') {
                            $bg_color = 'bg-yellow-400';
                        } elseif ($status === 'lulus') {
                            $bg_color = 'bg-green-500';
                        } elseif ($status === 'tolak' || $status === 'tidak lulus') {
                            $bg_color = 'bg-red-500';
                        } elseif ($status === 'buat pemeriksaan') {
                            $bg_color = 'bg-blue-600';
                        } elseif ($status === 'sedang diproses') {
                            $bg_color = 'bg-indigo-500';
                        } else {
                            $bg_color = 'bg-gray-400';
                        }

                        if ($status === 'buat pemeriksaan') {
                            $onclick_action = "window.location='$pemeriksaan_url';";
                        } else {
                            $escaped_alert_message = str_replace("'", "\'", "Status permohonan #{$item->id_permohonan} adalah '{$status_raw}'. Tiada tindakan diperlukan pada masa ini.");
                            $onclick_action = "alert('{$escaped_alert_message}');";
                        }
                    @endphp

                    <tr class="bg-white border-b border-gray-200">
                        <td class="border border-gray-300 px-4 py-3 align-top">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1 text-gray-700 font-semibold">
                                    <p>ID Permohonan:</p>
                                    <p>ID User:</p>
                                    <p>No. Pendaftaran:</p>
                                    <p>Lokasi:</p>
                                </div>
                                <div class="space-y-1 text-gray-800">
                                    <p>{{ $item->id_permohonan ?? 'N/A' }}</p>
                                    <p>{{ $item->id_user }}</p>
                                    <p>{{ $item->no_pendaftaran }}</p>
                                    <p>{{ $item->lokasi }}</p>
                                </div>

                                <div class="space-y-1 text-gray-700 font-semibold">
                                    <p>Bil. Penumpang:</p>
                                    <p>Kod Projek:</p>
                                    <p>Hak Milik:</p>
                                </div>
                                <div class="space-y-1 text-gray-800">
                                    <p>{{ $item->bil_penumpang }}</p>
                                    <p>{{ $item->kod_projek }}</p>
                                    <p>{{ $item->hak_milik }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="border border-gray-300 p-0 align-top">
                            <div class="h-full w-full flex items-center justify-center
                                {{ $bg_color }} text-white font-semibold text-center py-4 
                                cursor-pointer hover:brightness-110"
                                onclick="{{ $onclick_action }}">
                                
                                {{ ucfirst($status_raw) }}
                                
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-gray-500 py-6">Tiada rekod permohonan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

@endsection
