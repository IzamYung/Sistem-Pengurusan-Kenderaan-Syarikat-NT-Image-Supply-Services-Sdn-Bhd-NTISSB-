@extends('admin_site.layout.layout')

@section('title', 'Halaman Utama Admin')

@section('content')
<div class="max-w-6xl mx-auto mt-12 mb-24 px-4 sm:px-6">

    @if(request()->has('id_permohonan') && isset($permohonan))
        <div class="mb-10 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-1 text-[#1e3a8a] tracking-tight">
                Maklumat Permohonan
            </h1>
            <p class="text-gray-500 mb-5 font-medium">Semak butiran dan status kerosakan kenderaan sebelum pengesahan.</p>
        </div>

        <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-[2.5rem] overflow-hidden border border-gray-100 mb-10">
            <div class="bg-[#1e3a8a] px-8 py-4 flex justify-between items-center">
                <h2 class="text-white font-black uppercase text-xs tracking-[0.2em]">Butiran Permohonan</h2>
                <span class="bg-blue-400/20 text-white text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-widest">ID: #{{ $permohonan->id_permohonan }}</span>
            </div>

            <div class="p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-sm">
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Nama Pemohon</span>
                            <p class="font-bold text-gray-800 text-lg">{{ $permohonan->user->nama ?? $permohonan->id_user }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">No. Pendaftaran Kenderaan</span>
                            <p class="font-bold text-[#1e3a8a]">{{ $permohonan->no_pendaftaran }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Tarikh Mohon</span>
                            <p class="font-bold text-gray-700">{{ $permohonan->tarikh_mohon }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Lokasi / Tujuan</span>
                            <p class="font-bold text-gray-700">{{ $permohonan->lokasi }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Bil. Penumpang</span>
                            <p class="font-bold text-gray-700">{{ $permohonan->bil_penumpang }} Orang</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Kod Projek / Hak Milik</span>
                            <p class="font-bold text-gray-700">{{ $permohonan->kod_projek }} | {{ $permohonan->hak_milik ?? '-' }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Status Pengesahan</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black uppercase bg-gray-100 text-gray-600 w-fit mt-1 italic">
                                {{ $permohonan->status_pengesahan }}
                            </span>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2 pt-6 border-t border-gray-50">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-3 block">Gambar Speedometer Sebelum</span>
                        
                        @if($permohonan->speedometer_sebelum)
                            <div class="relative group w-fit">
                                <img src="{{ asset('storage/' . $permohonan->speedometer_sebelum) }}"
                                    alt="Speedometer Sebelum"
                                    class="cursor-pointer speedometer-preview rounded-2xl border-4 border-white shadow-lg transition-transform hover:scale-[1.02] duration-300"
                                    style="max-height: 180px; width: auto;"
                                    data-modal-open="modalSpeedometer"
                                    data-modal-img="{{ asset('storage/' . $permohonan->speedometer_sebelum) }}">
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 rounded-2xl flex items-center justify-center transition-opacity pointer-events-none">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Klik Besarkan</span>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-2xl p-8 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Tiada rekod imej speedometer</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-span-1 md:col-span-2 pt-6">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-3 block">Lampiran Dokumen</span>
                        @if(!empty($permohonan->lampiran) && count($permohonan->lampiran) > 0)
                            <div class="flex flex-wrap gap-3">
                                @foreach($permohonan->lampiran as $file)
                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                       class="flex items-center gap-2 bg-blue-50 text-[#1e3a8a] px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-100 transition-colors border border-blue-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        {{ basename($file) }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 bg-orange-50 text-orange-600 px-4 py-2 rounded-xl border border-orange-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="text-[10px] font-black uppercase tracking-wider">Tiada dokumen lampiran disertakan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mb-8">
            <div class="h-[2px] flex-1 bg-gray-100"></div>
            <h2 class="text-2xl font-black text-[#1e3a8a] uppercase tracking-tighter">Laporan Pemeriksaan</h2>
            <div class="h-[2px] flex-1 bg-gray-100"></div>
        </div>

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

            $rosakArr = [];
            $perhatianArr = [];
            foreach($pemeriksaan as $p) {
                $labelPenuh = $kamusLabels[$p->nama_komponen] ?? $p->nama_komponen;
                if($p->status == 3) $rosakArr[] = $labelPenuh;
                if($p->status == 2) $perhatianArr[] = $labelPenuh;
            }
            $ayatFinalAuto = "";
            if(count($rosakArr) > 0) $ayatFinalAuto .= "Kerosakan kritikal pada: " . implode(", ", $rosakArr) . ". ";
            if(count($perhatianArr) > 0) $ayatFinalAuto .= "Perlu perhatian segera bagi: " . implode(", ", $perhatianArr) . ".";
        @endphp

        <div class="space-y-8">
            @foreach($sections as $sectionName => $components)
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm">
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
        </div>

        <div class="sticky bottom-8 mt-12 flex flex-col md:flex-row justify-center items-center gap-4 bg-white/80 backdrop-blur-md p-6 rounded-[2rem] shadow-2xl border border-gray-100 z-40">
            <form action="{{ route('admin_site.permohonan.lulus', $permohonan->id_permohonan) }}" method="POST">
                @csrf
                <button class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-lg shadow-green-100 active:scale-95">
                    Lulus Permohonan
                </button>
            </form>

            <form action="{{ route('admin_site.permohonan.tidak_lulus', $permohonan->id_permohonan) }}" method="POST">
                @csrf
                <button class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-lg shadow-red-100 active:scale-95">
                    Tidak Lulus
                </button>
            </form>

            <form action="{{ route('admin_site.permohonan.tidak_lulus_rosak', $permohonan->id_permohonan) }}" method="POST">
                @csrf
                <button class="px-8 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-lg shadow-orange-100 active:scale-95">
                    Kerosakan & Gagal
                </button>
            </form>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('admin_site.halaman_utama') }}"
               class="text-[#1e3a8a] text-xs font-black uppercase tracking-widest hover:underline decoration-2 underline-offset-8 transition-all">
                ← Kembali ke Senarai Utama
            </a>
        </div>

        <div id="modalSpeedometer" data-modal class="fixed inset-0 z-[100] hidden bg-black/90 flex items-center justify-center p-4 backdrop-blur-sm">
            <div data-modal-card class="relative bg-white rounded-[2.5rem] shadow-2xl transform scale-95 opacity-0 transition-all duration-300 p-4 max-w-4xl w-full overflow-hidden">
                <div class="flex justify-center bg-gray-50 rounded-[2rem] overflow-hidden">
                    <img id="modalSpeedometerImg" src="" alt="Speedometer" class="max-h-[75vh] w-auto object-contain">
                </div>
                <div class="flex justify-center mt-4">
                    <button data-modal-close class="px-10 py-3 bg-[#1e3a8a] text-white rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] hover:bg-blue-800 transition-all">Tutup Paparan</button>
                </div>
            </div>
        </div>

    @else

        <div class="mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-1 text-[#1e3a8a] tracking-tight">
                Senarai Semakan Permohonan
            </h1>
            <p class="text-gray-500 mb-5 font-medium">Sila pilih permohonan di bawah untuk melakukan pengesahan maklumat dan inventori kenderaan.</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse ($senarai as $item)
                <a href="{{ route('admin_site.halaman_utama', ['id_permohonan' => $item->id_permohonan]) }}" class="group">
                    <div class="bg-white shadow-sm border border-gray-100 rounded-3xl p-6 transition-all duration-300 group-hover:shadow-[0_20px_50px_rgba(0,0,0,0.06)] group-hover:border-blue-100 group-hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gray-100 group-hover:bg-[#1e3a8a] transition-colors"></div>
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-6">
                            <div class="flex-1">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1 block">Nama Pemohon</span>
                                <p class="font-black text-xl text-gray-800 leading-tight mb-3 group-hover:text-[#1e3a8a] transition-colors">
                                    {{ $item->user->nama ?? $item->id_user }}
                                </p>
                                <div class="flex flex-wrap gap-x-6 gap-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-tighter">
                                            No. Plat: <span class="text-gray-800">{{ $item->no_pendaftaran }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-tighter">
                                            Model: <span class="text-gray-800">{{ $item->kenderaan->model ?? '-' }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-tighter">
                                            Tujuan: <span class="text-gray-800">{{ $item->lokasi ?? '-' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex md:flex-col items-center md:items-end justify-between md:justify-center border-t md:border-t-0 md:border-l border-gray-50 pt-4 md:pt-0 md:pl-8">
                                <div class="text-left md:text-right">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block">Tarikh Pelepasan</span>
                                    <p class="font-black text-gray-800 text-sm">
                                        {{ $item->tarikh_pelepasan ? $item->tarikh_pelepasan->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                                <div class="mt-2 hidden md:block">
                                    <div class="bg-gray-50 p-2 rounded-xl group-hover:bg-blue-50 transition-colors">
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#1e3a8a] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white border border-dashed border-gray-200 rounded-[2.5rem] p-12 text-center shadow-sm">
                    <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight mb-2">Semua Selesai</h3>
                    <p class="text-gray-500 max-w-xs mx-auto text-sm leading-relaxed">Tiada permohonan baharu yang memerlukan tindakan pengesahan anda buat masa ini.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection