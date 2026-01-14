@extends('admin_site.layout.layout')

@section('title', 'Kerosakan Kenderaan')

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-24 px-4 sm:px-6">

    {{-- TAMBAH LAPORAN --}}
    @if($action === 'add')
        <div class="max-w-3xl mx-auto bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-[#1e3a8a] to-blue-800 px-8 py-6 text-center">
                <h2 class="text-white font-bold text-xl tracking-wide uppercase">Tambah Laporan Kerosakan</h2>
            </div>

            <form action="{{ route('admin_site.kerosakkan_kenderaan.store') }}" method="POST" class="p-8 md:p-10">
                @csrf
                <div class="grid gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">No Pendaftaran Kenderaan</label>
                        <select name="no_pendaftaran" id="no_pendaftaran"
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50 font-bold"
                            onchange="document.getElementById('model').value = this.selectedOptions[0].dataset.model;" required>
                            <option value="">-- Pilih Kenderaan --</option>
                            @foreach($kenderaan as $k)
                                <option value="{{ $k->no_pendaftaran }}" data-model="{{ $k->model }}">
                                    {{ $k->no_pendaftaran }} ({{ $k->model }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Jenis Kerosakan</label>
                        <input type="text" name="jenis_kerosakan" 
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                            placeholder="Contoh: Lampu Depan Pecah / Masalah Enjin" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Ulasan Terperinci</label>
                        <textarea name="ulasan" rows="4" 
                            class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                            placeholder="Sila jelaskan kerosakan dengan lebih lanjut..."></textarea>
                    </div>
                </div>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 items-center justify-center">
                    <a href="{{ route('admin_site.kerosakkan_kenderaan') }}"
                        class="w-full sm:w-auto px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl hover:bg-gray-200 font-black transition-all text-sm uppercase tracking-wider text-center">
                        Batal
                    </a>

                    <button type="submit"
                        class="w-full sm:w-auto px-12 py-4 bg-[#1e3a8a] text-white rounded-2xl hover:bg-black font-black transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>

    @elseif(request()->has('id_kerosakan') && isset($kerosakan))
        {{-- DETAIL PAGE --}}
        <div class="mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1e3a8a] tracking-tight">Maklumat Laporan Kerosakan</h1>
            <p class="text-gray-500 mb-5 font-medium">Maklumat penuh laporan kerosakan kenderaan.</p>
        </div>

        <div class=" flex flex-col items-center max-w-5xl mx-auto space-y-8">
            {{-- INFO LAPORAN --}}
            <div class="bg-white w-2xl p-8 rounded-[2rem] shadow-lg border border-gray-100 space-y-4">
            {{-- No Pendaftaran --}}
            <div class="flex flex-col">
                <span class="font-black text-gray-400 uppercase text-[10px] tracking-widest mb-1">No Pendaftaran</span>
                <span class="font-bold text-gray-800">{{ $kerosakan->no_pendaftaran }}</span>
            </div>

            {{-- Model --}}
            <div class="flex flex-col">
                <span class="font-black text-gray-400 uppercase text-[10px] tracking-widest mb-1">Model</span>
                <span class="font-bold text-gray-800">{{ $kerosakan->kenderaan->model ?? '-' }}</span>
            </div>

            {{-- Jenis Kerosakan --}}
            <div class="flex flex-col">
                <span class="font-black text-gray-400 uppercase text-[10px] tracking-widest mb-1">Jenis Kerosakan</span>
                <span class="font-bold text-red-600">{{ $kerosakan->jenis_kerosakan }}</span>
            </div>

            {{-- Tarikh Laporan --}}
            <div class="flex flex-col">
                <span class="font-black text-gray-400 uppercase text-[10px] tracking-widest mb-1">Tarikh Laporan</span>
                <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($kerosakan->tarikh_laporan)->format('d/m/Y') }}</span>
            </div>

            {{-- Ulasan / Catatan --}}
            <div class="flex flex-col">
                <span class="font-black text-gray-400 uppercase text-[10px] tracking-widest mb-1">Ulasan / Catatan</span>
                <p class="text-sm text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-200">{{ $kerosakan->ulasan ?? '-' }}</p>
            </div>
        </div>

            @if($kerosakan->id_permohonan != 0)
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-[2px] flex-1 bg-gray-100"></div>
                    <h2 class="text-2xl font-black text-[#1e3a8a] uppercase tracking-tighter">Laporan Pemeriksaan</h2>
                    <div class="h-[2px] flex-1 bg-gray-100"></div>
                </div>

                {{-- LAPORAN PEMERIKSAAN --}}
                @php
                    $kamusLabels = [
                        'badan_luaran' => 'Badan Luaran Kenderaan',
                        'cermin_hadapan' => 'Cermin Hadapan / Kaca',
                        'pengelap_cermin' => 'Pengelap Cermin',
                        'lampu' => 'Lampu (Hadapan, Brek, Isyarat Belok)',
                        'lampu_dalaman' => 'Lampu Dalaman',
                        'penghawa_dingin' => 'Operasi Penghawa Dingin',
                        'pemanasan' => 'Pemanasan',
                        'brek' => 'Brek (Pad / Kasut Brek)',
                        'salur_hos_brek' => 'Salur & Hos Brek',
                        'sistem_stereng' => 'Sistem Stereng',
                        'penyerap_kejutan' => 'Penyerap Kejutan & Topang',
                        'sistem_ekzos' => 'Sistem Ekzos',
                        'salur_hos_bahan_api' => 'Salur & Hos Bahan Api',
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
                        'caj_bateri' => 'Caj Bateri',
                        'bendalir_bateri' => 'Bendalir Bateri',
                        'kabel_sambungan' => 'Kabel & Sambungan',
                        'bunga_kiri_hadapan' => 'Kedalaman Bunga (Kiri Hadapan)',
                        'bunga_kiri_belakang' => 'Kedalaman Bunga (Kiri Belakang)',
                        'bunga_kanan_hadapan' => 'Kedalaman Bunga (Kanan Hadapan)',
                        'bunga_kanan_belakang' => 'Kedalaman Bunga (Kanan Belakang)',
                        'udara_kiri_hadapan' => 'Tekanan Udara (Kiri Hadapan)',
                        'udara_kiri_belakang' => 'Tekanan Udara (Kiri Belakang)',
                        'udara_kanan_hadapan' => 'Tekanan Udara (Kanan Hadapan)',
                        'udara_kanan_belakang' => 'Tekanan Udara (Kanan Belakang)',
                        'penjajaran' => 'Penjajaran (Alignment)',
                        'pengimbangan' => 'Pengimbangan (Balancing)',
                        'putaran' => 'Putaran (Rotation)',
                        'tayar_baru' => 'Tayar Baru (Ganti)',
                    ];

                    $sections = [
                        'Bahagian Dalaman / Luaran' => [
                            'badan_luaran' => $kamusLabels['badan_luaran'],
                            'cermin_hadapan' => $kamusLabels['cermin_hadapan'],
                            'pengelap_cermin' => $kamusLabels['pengelap_cermin'],
                            'lampu' => $kamusLabels['lampu'],
                            'lampu_dalaman' => $kamusLabels['lampu_dalaman'],
                            'penghawa_dingin' => $kamusLabels['penghawa_dingin'],
                            'pemanasan' => $kamusLabels['pemanasan'],
                        ],
                        'Bahagian Bawah Kenderaan' => [
                            'brek' => $kamusLabels['brek'],
                            'salur_hos_brek' => $kamusLabels['salur_hos_brek'],
                            'sistem_stereng' => $kamusLabels['sistem_stereng'],
                            'penyerap_kejutan' => $kamusLabels['penyerap_kejutan'],
                            'sistem_ekzos' => $kamusLabels['sistem_ekzos'],
                            'salur_hos_bahan_api' => $kamusLabels['salur_hos_bahan_api'],
                        ],
                        'Bahagian Bawah Bonet' => [
                            'minyak_enjin' => $kamusLabels['minyak_enjin'],
                            'bendalir_brek' => $kamusLabels['bendalir_brek'],
                            'bendalir_stereng' => $kamusLabels['bendalir_stereng'],
                            'bendalir_pencuci' => $kamusLabels['bendalir_pencuci'],
                            'tali_sawat_hos' => $kamusLabels['tali_sawat_hos'],
                            'antibeku_penyejuk' => $kamusLabels['antibeku_penyejuk'],
                            'penapis_udara' => $kamusLabels['penapis_udara'],
                            'penapis_kabin' => $kamusLabels['penapis_kabin'],
                            'penapis_bahan_api' => $kamusLabels['penapis_bahan_api'],
                            'palam_pencucuh' => $kamusLabels['palam_pencucuh'],
                            'bendalir_transmisi' => $kamusLabels['bendalir_transmisi'],
                            'sistem_gantung' => $kamusLabels['sistem_gantung'],
                        ],
                        'Bateri' => [
                            'caj_bateri' => $kamusLabels['caj_bateri'],
                            'bendalir_bateri' => $kamusLabels['bendalir_bateri'],
                            'kabel_sambungan' => $kamusLabels['kabel_sambungan'],
                        ],
                        'Tayar - Kondisi & Tekanan' => [
                            'bunga_kiri_hadapan' => $kamusLabels['bunga_kiri_hadapan'],
                            'bunga_kiri_belakang' => $kamusLabels['bunga_kiri_belakang'],
                            'bunga_kanan_hadapan' => $kamusLabels['bunga_kanan_hadapan'],
                            'bunga_kanan_belakang' => $kamusLabels['bunga_kanan_belakang'],
                            'udara_kiri_hadapan' => $kamusLabels['udara_kiri_hadapan'],
                            'udara_kiri_belakang' => $kamusLabels['udara_kiri_belakang'],
                            'udara_kanan_hadapan' => $kamusLabels['udara_kanan_hadapan'],
                            'udara_kanan_belakang' => $kamusLabels['udara_kanan_belakang'],
                        ],
                        'Penyelenggaraan Tayar' => [
                            'penjajaran' => $kamusLabels['penjajaran'],
                            'pengimbangan' => $kamusLabels['pengimbangan'],
                            'putaran' => $kamusLabels['putaran'],
                            'tayar_baru' => $kamusLabels['tayar_baru'],
                        ],
                    ];
                @endphp

                @foreach($sections as $sectionName => $components)
                    <div class="bg-white w-5xl rounded-3xl border border-gray-100 overflow-hidden shadow-sm">
                        <div class="bg-gray-50 px-6 py-3 border-b border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $sectionName }}</p>
                        </div>

                        <div class="p-6">
                            @php $adaMasalah = false; @endphp
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($components as $key => $label)
                                    @php
                                        $pmItem = $pemeriksaan->firstWhere('nama_komponen', $key);
                                        $status = $pmItem->status ?? null;
                                        $ulasan = $pmItem->ulasan ?? '-';
                                        if ($status == 2 || $status == 3) { $adaMasalah = true; }
                                    @endphp

                                    @if($status == 2 || $status == 3)
                                        <div class="flex flex-col md:flex-row md:items-start justify-between p-4 rounded-2xl border-l-4 {{ $status == 3 ? 'border-red-500 bg-red-50/30' : 'border-orange-400 bg-orange-50/30' }}">
                                            <div class="flex-1">
                                                <p class="font-bold text-gray-800">{{ $label }}</p>
                                                <div class="mt-2 flex items-center gap-3">
                                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md {{ $status == 3 ? 'bg-red-500 text-white' : 'bg-orange-400 text-white' }}">
                                                        {{ $status == 3 ? 'Rosak (3)' : 'Perlu Perhatian (2)' }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 font-medium">Ulasan: <span class="text-gray-700 italic">{{ $ulasan }}</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @if(!$adaMasalah)
                                    <div class="flex items-center gap-3 py-2 px-2">
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                        <p class="text-sm text-green-700 font-bold italic uppercase tracking-tighter">Bahagian ini dalam keadaan baik.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- BUTTON SELESAI / BACK --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <form action="{{ route('admin_site.kerosakkan_kenderaan.selesai', ['id' => $kerosakan->id_laporan]) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button class="w-full px-10 py-4 bg-green-600 text-white rounded-2xl font-black shadow-lg hover:bg-green-700 transition-all active:scale-95 text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Selesai
                    </button>
                </form>
                <a href="{{ route('admin_site.kerosakkan_kenderaan') }}" class="w-full sm:w-auto px-10 py-4 bg-gray-200 text-gray-600 rounded-2xl font-black hover:bg-gray-300 transition-all text-sm uppercase tracking-wider text-center">
                    Kembali ke Senarai
                </a>
            </div>
        </div>

    @else
        {{-- LIST PAGE --}}
        <div class="mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#1e3a8a] tracking-tight">Senarai Laporan Kerosakan</h1>
            <p class="text-gray-500 mb-5 font-medium">Klik laporan untuk lihat maklumat penuh.</p>
        </div>

        <div class="flex justify-end max-w-5xl mx-auto mb-8">
            <a href="{{ route('admin_site.kerosakkan_kenderaan', ['action' => 'add']) }}"
                class="group px-6 py-4 bg-[#1e3a8a] text-white rounded-2xl shadow-xl hover:bg-black transition-all duration-300 flex items-center gap-3 active:scale-95">
                <span class="font-black uppercase tracking-tighter text-sm">Tambah Laporan Baru</span>
                <div class="bg-white/20 p-1.5 rounded-lg group-hover:bg-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                </div>
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-1">
            @forelse($senarai as $item)
                <a href="{{ route('admin_site.kerosakkan_kenderaan', ['id_kerosakan' => $item->id_laporan]) }}" class="group block bg-white shadow-md rounded-[2.5rem] border border-gray-100 hover:shadow-lg transition-all p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">

                        {{-- Icon + Model + No Pendaftaran --}}
                        <div class="flex items-center gap-6 w-full md:w-auto">
                            <div class="bg-blue-50 p-4 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-xl text-[#1e3a8a] group-hover:text-blue-600 transition-colors">
                                    {{ $item->kenderaan->model ?? '-' }}
                                </p>
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mt-1">
                                    No Pendaftaran: <span class="text-gray-700 font-mono">{{ $item->no_pendaftaran }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Tarikh Laporan --}}
                        <div class="flex flex-row md:flex-col items-center md:items-end justify-between w-full md:w-auto border-t md:border-0 pt-4 md:pt-0 border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tarikh Laporan</p>
                            <p class="font-extrabold text-lg text-gray-700">
                                {{ \Carbon\Carbon::parse($item->tarikh_laporan)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white border-2 border-dashed border-gray-200 rounded-[3rem] py-20 px-6 text-center shadow-sm">
                    <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 mb-2">Tiada Laporan Kerosakan</h3>
                    <p class="text-gray-400 font-medium max-w-xs mx-auto">
                        Semua kenderaan dalam keadaan baik. Tekan butang di atas untuk menambah laporan baru.
                    </p>
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection
