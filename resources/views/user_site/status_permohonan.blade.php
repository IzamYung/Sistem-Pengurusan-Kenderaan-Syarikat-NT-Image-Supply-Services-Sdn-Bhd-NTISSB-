@extends('user_site.layout.layout')

@section('title', 'Status Permohonan')

@section('content')

@if(isset($page) && $page === 'pemeriksaan')
    <div class="max-w-4xl mx-auto p-4 mb-10">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            
            <div class="bg-[#1e3a8a] text-white text-center py-8">
                <h3 class="text-2xl md:text-3xl font-bold tracking-wide">Laporan Pemeriksaan Kenderaan</h3>
                <p class="text-blue-100 mt-2 text-sm">Sila lengkapkan status pemeriksaan di bawah sebelum memulakan perjalanan.</p>
            </div>

            <div class="p-6 md:p-8">
                <form action="{{ route('user_site.permohonan.simpan_pemeriksaan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_permohonan" value="{{ $permohonan->id_permohonan }}">

                    <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <label for="mileage" class="block font-bold text-gray-800 mb-2 uppercase text-xs tracking-wider">
                            Gambar Mileage Semasa
                        </label>
                        <input type="file" 
                            class="w-full bg-white border border-gray-300 rounded-lg p-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mileage') border-red-500 @enderror" 
                            id="mileage" 
                            name="mileage" 
                            accept=".jpg,.jpeg,.png,.webp" 
                            required>
                        <p class="text-[11px] text-gray-500 mt-2 italic font-medium">*Sila muat naik gambar paparan speedometer (jarak perbatuan) kenderaan.</p>
                        @error('mileage')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-4 mb-4 text-[10px] font-bold uppercase text-gray-500 px-2">
                        <div class="flex items-center gap-2 px-2 py-1 bg-green-50 rounded border border-green-200"><span class="w-2 h-2 bg-green-500 rounded-full"></span> 1: Semak & Sahkan</div>
                        <div class="flex items-center gap-2 px-2 py-1 bg-yellow-50 rounded border border-yellow-200"><span class="w-2 h-2 bg-yellow-500 rounded-full"></span> 2: Perlu Perhatian</div>
                        <div class="flex items-center gap-2 px-2 py-1 bg-red-50 rounded border border-red-200"><span class="w-2 h-2 bg-red-500 rounded-full"></span> 3: Tindakan Segera</div>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-[11px] tracking-wider">
                                <tr>
                                    <th class="p-4 border-b text-left font-bold w-1/2">Item / Bahagian Pemeriksaan</th>
                                    <th class="p-4 border-b text-center font-bold">1</th>
                                    <th class="p-4 border-b text-center font-bold">2</th>
                                    <th class="p-4 border-b text-center font-bold">3</th>
                                </tr>
                            </thead>

                            <tbody>
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

                                @foreach($sections as $sectionName => $items)
                                    <tr>
                                        <td colspan="4" class="bg-blue-50 text-[#1e3a8a] font-bold p-3 text-sm border-y border-blue-100">
                                            {{ $sectionName }}
                                        </td>
                                    </tr>

                                    @foreach($items as $key => $label)
                                        <tr class="inspection-item border-b hover:bg-gray-50 transition" data-key="{{ $key }}">
                                            <td class="p-4 font-medium text-gray-700">
                                                {{ $label }}
                                            </td>

                                            @for($i = 1; $i <= 3; $i++)
                                                <td class="text-center p-4">
                                                    <input type="radio" 
                                                        name="pemeriksaan[{{ $key }}][status]" 
                                                        value="{{ $i }}" 
                                                        required
                                                        class="status-radio w-5 h-5 cursor-pointer accent-blue-600"
                                                        data-key="{{ $key }}"
                                                        data-status="{{ $i }}"
                                                        {{ old("pemeriksaan.$key.status") == $i ? 'checked' : '' }}>
                                                </td>
                                            @endfor
                                        </tr>

                                        <tr id="ulasan-row-{{ $key }}" class="hidden bg-orange-50 border-b">
                                            <td colspan="4" class="p-4">
                                                <label class="font-bold text-orange-800 block mb-2 text-[10px] uppercase">
                                                    Penjelasan / Ulasan Kerosakan
                                                </label>
                                                <textarea 
                                                    name="pemeriksaan[{{ $key }}][ulasan]" 
                                                    id="ulasan-{{ $key }}" 
                                                    rows="2" 
                                                    placeholder="Sila berikan butiran kerosakan..."
                                                    class="w-full border-orange-200 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 overflow-auto resize-none p-3 @error("pemeriksaan.$key.ulasan") border-red-500 @enderror">{{ old("pemeriksaan.$key.ulasan") }}</textarea>
                                                
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

                    <div class="mt-10">
                        <button type="submit" 
                            class="w-full bg-[#1e3a8a] hover:bg-blue-800 text-white py-4 rounded-xl shadow-lg font-bold text-lg transition-all transform hover:-translate-y-1">
                            Hantar Laporan Pemeriksaan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@else
    <div class="max-w-6xl mx-auto mt-10 mb-20 px-4">
        <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-10 text-[#1e3a8a] tracking-tight">Status Permohonan Kenderaan</h1>

        <div class="shadow-2xl rounded-2xl overflow-hidden border border-gray-200 bg-white">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 text-gray-600 uppercase text-[11px] tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold">Butiran Permohonan</th>
                        <th class="px-6 py-4 w-56 text-center font-bold">Status & Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($permohonan ?? [] as $item)
                        @php
                            $status_raw = $item->status_pengesahan;
                            $status = strtolower($status_raw);
                            $pemeriksaan_url = route('user_site.permohonan.pemeriksaan', $item->id_permohonan);

                            if ($status === 'menunggu kelulusan' || $status === 'menunggu') {
                                $bg_color = 'bg-yellow-500';
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                            } elseif ($status === 'lulus') {
                                $bg_color = 'bg-green-600';
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>';
                            } elseif ($status === 'tolak' || $status === 'tidak lulus' || $status === 'tidak lulus - kerosakan') {
                                $bg_color = 'bg-red-600';
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                            } elseif ($status === 'buat pemeriksaan') {
                                $bg_color = 'bg-blue-600';
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>';
                            } elseif ($status === 'sedang diproses') {
                                $bg_color = 'bg-indigo-600';
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
                            } else {
                                $bg_color = 'bg-gray-500';
                                $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">ID Permohonan</span>
                                        <span class="font-mono font-bold text-blue-700 text-base">#{{ $item->id_permohonan ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">No. Pendaftaran</span>
                                        <span class="font-bold text-gray-800 text-base">{{ $item->no_pendaftaran }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Lokasi / Tujuan</span>
                                        <span class="text-gray-700 font-medium">{{ $item->lokasi }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Projek / Hak Milik</span>
                                        <span class="text-gray-700 font-medium">{{ $item->kod_projek }} ({{ $item->hak_milik }})</span>
                                    </div>
                                    <div class="flex flex-col col-span-full pt-2 border-t border-gray-100">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Bilangan Penumpang</span>
                                        <span class="text-gray-700 font-bold">{{ $item->bil_penumpang }} Orang</span>
                                    </div>
                                </div>
                            </td>

                            <td class="p-0 align-stretch">
                                <div class="h-full min-h-[160px] flex items-center justify-center
                                    {{ $bg_color }} text-white font-bold text-center px-4 py-6
                                    cursor-pointer hover:brightness-110 transition-all uppercase tracking-widest text-sm shadow-inner"
                                    @if(strtolower($status_raw) !== 'buat pemeriksaan')
                                        data-modal-open="modalPermohonan"
                                        data-no="{{ $item->no_pendaftaran }}"
                                        data-model="{{ $item->kenderaan->model ?? '-' }}"
                                        data-nama="{{ $item->user->name ?? '-' }}"
                                        data-tarikh="{{ optional($item->tarikh_pelepasan)->format('d/m/Y') }}"
                                        data-lokasi="{{ $item->lokasi }}"
                                        data-bil="{{ $item->bil_penumpang }}"
                                        data-kod="{{ $item->kod_projek }}"
                                        data-hak="{{ $item->hak_milik }}"
                                        data-lampiran='@json($item->lampiran)'
                                    @else
                                        onclick="window.location='{{ $pemeriksaan_url }}'"
                                    @endif
                                >
                                    <div class="flex flex-col items-center gap-3">
                                        {!! $icon !!}
                                        
                                        <span class="block leading-tight px-2">
                                            {{ strtolower($status_raw) === 'tidak lulus - kerosakan' ? 'Tidak Lulus' : ucfirst($status_raw) }}
                                        </span>

                                        @if(strtolower($status_raw) === 'buat pemeriksaan')
                                            <span class="text-[9px] font-normal opacity-90 mt-1 uppercase tracking-tighter bg-black/20 px-2 py-1 rounded">Klik untuk pemeriksaan</span>
                                        @else
                                            <span class="text-[9px] font-normal opacity-90 mt-1 uppercase tracking-tighter bg-black/20 px-2 py-1 rounded">Klik untuk butiran</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-gray-500 py-24 bg-gray-50">
                                <p class="text-lg font-medium">Tiada rekod permohonan ditemui.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="modalPermohonan" 
             data-modal
             class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">

            <div data-modal-card
                 class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl 
                        transform scale-95 opacity-0 transition-all duration-200 overflow-hidden">
                
                <div class="bg-gray-100 px-8 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-extrabold text-[#1e3a8a] text-center uppercase tracking-wide">
                        Maklumat Lengkap Permohonan
                    </h2>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-2 gap-y-5 gap-x-6 text-sm">
                        <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">No Pendaftaran</p><p id="m-no" class="text-base font-bold text-gray-800"></p></div>
                        <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Model Kenderaan</p><p id="m-model" class="text-base font-bold text-gray-800"></p></div>
                        <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Tarikh Pelepasan</p><p id="m-tarikh" class="text-base font-bold text-blue-700"></p></div>
                        <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Lokasi / Tujuan</p><p id="m-lokasi" class="text-base font-bold text-gray-800"></p></div>
                        <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Bil Penumpang</p><p id="m-bil" class="text-base font-bold text-gray-800"></p></div>
                        <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Kod Projek</p><p id="m-kod" class="text-base font-bold text-gray-800"></p></div>
                        <div class="border-b border-gray-100 pb-2 col-span-full"><p class="font-bold text-gray-400 uppercase text-[10px]">Hak Milik</p><p id="m-hak" class="text-base font-bold text-gray-800"></p></div>
                    </div>

                    <div class="mt-8">
                        <p class="font-bold text-[#1e3a8a] mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                            Lampiran Dokumen
                            <span class="h-px flex-1 bg-gray-200"></span>
                        </p>
                        <div id="m-lampiran" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                        <p id="m-no-lampiran" class="text-sm text-gray-400 italic hidden">Tiada lampiran disertakan.</p>
                    </div>

                    <div class="mt-10 text-center">
                        <button data-modal-close 
                            class="px-12 py-3 bg-gray-900 text-white rounded-xl hover:bg-black font-bold transition-all shadow-lg hover:shadow-xl active:scale-95">
                            TUTUP
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection