@extends('admin_site.layout.layout')

@section('title', 'Rekod Permohonan')

@section('content')

<div class="max-w-6xl mx-auto mt-10 mb-20 px-4">
    {{-- TAJUK HALAMAN --}}
    <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-10 text-[#1e3a8a] tracking-tight">
        Rekod Permohonan Kenderaan (Admin)
    </h1>

    {{-- FILTER & INFO --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 w-full">
        <div class="relative w-full max-w-xs">
            <select id="filterPermohonan" class="w-full appearance-none bg-white border border-gray-300 rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer transition-all">
                <option value="">📂 Semua Rekod</option>
                <option value="selesai">✅ Lulus</option>
                <option value="tidak_lulus">❌ Tidak Lulus</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    {{-- SENARAI REKOD --}}
    <div class="flex flex-col gap-4">
        @forelse ($senarai as $item)
            @php
                $isLulus = $item->status_pengesahan !== 'Tidak Lulus';
                $statusVal = $isLulus ? 'selesai' : 'tidak_lulus';
                $statusColor = $isLulus ? 'border-l-green-500' : 'border-l-red-500';
            @endphp

            <div
                data-modal-open="modalPermohonan"
                data-status="{{ $statusVal }}"
                data-user="{{ $item->user->nama ?? '-' }}"
                data-idpekerja="{{ $item->user->id_pekerja ?? '-' }}"
                data-no="{{ $item->no_pendaftaran }}"
                data-model="{{ $item->kenderaan->model ?? '-' }}"
                data-tarikh="{{ $item->tarikh_pelepasan }}"
                data-lokasi="{{ $item->lokasi }}"
                data-bil="{{ $item->bil_penumpang }}"
                data-kod="{{ $item->kod_projek }}"
                data-hak="{{ $item->hak_milik }}"
                data-lampiran="{{ json_encode($item->lampiran ?? []) }}"
                data-speedometer-sebelum="{{ $item->speedometer_sebelum }}"
                data-speedometer-selepas="{{ $item->speedometer_selepas }}"
                data-ulasan="{{ $item->ulasan }}"
                class="permohonan-card bg-white shadow-md hover:shadow-xl rounded-2xl p-6 border border-gray-100 border-l-[6px] {{ $statusColor }} transition-all cursor-pointer group flex flex-col md:flex-row justify-between items-start md:items-center"
            >
                {{-- INFO KIRI (DATA PEMOHON & KENDERAAN) --}}
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama Pemohon</span>
                        <span class="font-bold text-gray-800 text-base group-hover:text-[#1e3a8a] transition-colors">{{ $item->user->nama ?? '-' }}</span>
                        <span class="text-[10px] font-mono text-gray-500">ID: {{ $item->user->id_pekerja ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kenderaan & Tujuan</span>
                        <span class="font-bold text-gray-700 text-sm">{{ $item->no_pendaftaran }} ({{ $item->kenderaan->model ?? '-' }})</span>
                        <span class="text-xs text-gray-500 truncate">{{ $item->lokasi ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status Akhir</span>
                        <div class="flex items-center gap-2 mt-1">
                            @if($isLulus)
                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full font-extrabold uppercase italic">Lulus</span>
                            @else
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded-full font-extrabold uppercase italic">Tidak Lulus</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- INFO KANAN (TARIKH) --}}
                <div class="mt-4 md:mt-0 md:text-right flex flex-col items-start md:items-end border-t md:border-t-0 pt-3 md:pt-0 w-full md:w-auto">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tarikh Mohon</span>
                    <span class="text-gray-900 font-bold">{{ $item->tarikh_mohon }}</span>
                    <span class="text-[9px] text-blue-500 font-bold mt-1 group-hover:underline">LIHAT REKOD PENUH →</span>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl py-20 text-center">
                <p class="text-gray-400 font-medium italic">Tiada rekod permohonan dijumpai dalam sistem.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ================= MODAL MAKLUMAT LENGKAP (ADMIN VIEW) ================= --}}
<div id="modalPermohonan" 
     class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">

    <div data-modal-card
         class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl 
                transform scale-95 opacity-0 transition-all duration-200 overflow-hidden max-h-[92vh] flex flex-col">
        
        {{-- Header Modal --}}
        <div class="bg-gray-100 px-8 py-5 border-b border-gray-200 sticky top-0 z-10 flex justify-center">
            <h2 class="text-xl font-extrabold text-[#1e3a8a] uppercase tracking-wide">
                Maklumat Lengkap Permohonan
            </h2>
        </div>

        {{-- Body Modal (Scrollable) --}}
        <div class="p-8 overflow-y-auto custom-scrollbar space-y-8">
            
            {{-- SEKSYEN 1: MAKLUMAT ASAS --}}
            <div>
                <p class="font-bold text-[#1e3a8a] mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    Butiran Pemohon & Kenderaan
                    <span class="h-px flex-1 bg-gray-200"></span>
                </p>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Nama Pemohon</p><p id="m-user" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">ID Pekerja</p><p id="m-idpekerja" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">No Pendaftaran</p><p id="m-no" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Model Kenderaan</p><p id="m-model" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Tarikh Pelepasan</p><p id="m-tarikh" class="text-base font-bold text-blue-700"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Lokasi / Tujuan</p><p id="m-lokasi" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Bil Penumpang</p><p id="m-bil" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2"><p class="font-bold text-gray-400 uppercase text-[10px]">Kod Projek</p><p id="m-kod" class="text-base font-bold text-gray-800"></p></div>
                    <div class="border-b border-gray-100 pb-2 col-span-full"><p class="font-bold text-gray-400 uppercase text-[10px]">Hak Milik</p><p id="m-hak" class="text-base font-bold text-gray-800"></p></div>
                </div>
            </div>

            {{-- SEKSYEN 2: SPEEDOMETER & ULASAN --}}
            <div id="m-speedometer-section" class="hidden space-y-6">
                <p class="font-bold text-[#1e3a8a] mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    Rekod Speedometer & Ulasan
                    <span class="h-px flex-1 bg-gray-200"></span>
                </p>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <p class="text-[10px] font-bold text-gray-500 uppercase text-center mb-2">📸 Mileage Sebelum</p>
                        <img id="m-speedometer-sebelum" class="w-full h-40 object-contain rounded-lg border bg-white shadow-inner">
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <p class="text-[10px] font-bold text-gray-500 uppercase text-center mb-2">📸 Mileage Selepas</p>
                        <img id="m-speedometer-selepas" class="w-full h-40 object-contain rounded-lg border bg-white shadow-inner">
                    </div>
                </div>

                <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                    <p class="font-bold text-[#1e3a8a] mb-2 text-xs uppercase tracking-widest">Ulasan Admin / Pemeriksa:</p>
                    <p id="m-ulasan" class="text-gray-700 text-sm italic font-medium leading-relaxed"></p>
                </div>
            </div>

            {{-- SEKSYEN 3: LAMPIRAN LAIN --}}
            <div>
                <p class="font-bold text-[#1e3a8a] mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    Lampiran Dokumen
                    <span class="h-px flex-1 bg-gray-200"></span>
                </p>
                <div id="m-lampiran" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                <p id="m-no-lampiran" class="text-sm text-gray-400 italic hidden">Tiada lampiran disertakan.</p>
            </div>

        </div>

        {{-- Footer Modal --}}
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end sticky bottom-0 z-10">
            <button data-modal-close 
                class="px-10 py-3 bg-gray-900 text-white rounded-xl hover:bg-black font-bold transition-all shadow-lg active:scale-95">
                TUTUP REKOD
            </button>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

@endsection