@extends('user_site.layout.layout')

@section('title', 'Rekod Permohonan')

@section('content')

<div class="max-w-6xl mx-auto mt-10 mb-20 px-4">
    <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-10 text-[#1e3a8a] tracking-tight">
        Rekod Permohonan Kenderaan
    </h1>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 w-full">
        <div class="relative w-full max-w-xs order-1 md:order-2">
            <select id="filterPermohonan" class="w-full appearance-none bg-white border border-gray-300 rounded-xl px-4 py-3 pr-10 text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer transition-all">
                <option value="">📂 Semua Rekod</option>
                <option value="selesai">✅ Lulus</option>
                <option value="tidak_lulus">❌ Tidak Lulus</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-4">
        @forelse ($senarai ?? [] as $item)
            @php
                $isLulus = $item->status_pengesahan !== 'Tidak Lulus';
                $statusVal = $isLulus ? 'selesai' : 'tidak_lulus';
                $statusColor = $isLulus ? 'border-l-green-500' : 'border-l-red-500';
            @endphp

            <div
                data-status="{{ $statusVal }}"
                data-modal-open="modalPermohonan"
                data-no="{{ $item->no_pendaftaran }}"
                data-model="{{ $item->kenderaan->model ?? '-' }}"
                data-tarikh="{{ $item->tarikh_pelepasan }}"
                data-lokasi="{{ $item->lokasi }}"
                data-bil="{{ $item->bil_penumpang }}"
                data-kod="{{ $item->kod_projek }}"
                data-hak="{{ $item->hak_milik }}"
                data-lampiran="{{ json_encode($item->lampiran ?? []) }}"
                class="permohonan-card bg-white shadow-md hover:shadow-xl rounded-2xl p-6 border border-gray-100 border-l-[6px] {{ $statusColor }} transition-all cursor-pointer group flex flex-col md:flex-row justify-between items-start md:items-center"
            >
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">No. Pendaftaran</span>
                        <span class="font-mono font-bold text-blue-700 text-lg group-hover:text-blue-800 transition-colors">{{ $item->no_pendaftaran }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Model & Tujuan</span>
                        <span class="font-bold text-gray-800">{{ $item->kenderaan->model ?? '-' }}</span>
                        <span class="text-sm text-gray-600 truncate">{{ $item->lokasi ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status Rekod</span>
                        <div class="flex items-center gap-2 mt-1">
                            @if($isLulus)
                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full font-extrabold uppercase">Lulus</span>
                            @else
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded-full font-extrabold uppercase">Tidak Lulus</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 md:text-right flex flex-col items-start md:items-end border-t md:border-t-0 pt-3 md:pt-0 w-full md:w-auto">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tarikh Mohon</span>
                    <span class="text-gray-900 font-bold">{{ $item->tarikh_mohon }}</span>
                    <span class="text-[9px] text-blue-500 font-bold mt-1 group-hover:underline">KLIK UNTUK BUTIRAN →</span>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl py-20 text-center">
                <p class="text-gray-400 font-medium italic">Tiada rekod permohonan ditemui dalam simpanan.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="modalPermohonan" data-modal class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div data-modal-card class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-200 overflow-hidden max-h-[90vh] flex flex-col">
        
        <div class="bg-gray-100 px-8 py-5 border-b border-gray-200 sticky top-0 z-10 flex justify-center">
            <h2 class="text-xl font-extrabold text-[#1e3a8a] uppercase tracking-wide">
                Maklumat Lengkap Permohonan
            </h2>
        </div>

        <div class="p-8 overflow-y-auto custom-scrollbar space-y-8">
            <div>
                <p class="font-bold text-[#1e3a8a] mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    Butiran Kenderaan & Perjalanan
                    <span class="h-px flex-1 bg-gray-200"></span>
                </p>
                <div class="grid grid-cols-2 gap-y-5 gap-x-6 text-sm">
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">No Pendaftaran</p>
                        <p id="m-no" class="text-base font-bold text-gray-800"></p>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">Model Kenderaan</p>
                        <p id="m-model" class="text-base font-bold text-gray-800"></p>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">Tarikh Pelepasan</p>
                        <p id="m-tarikh" class="text-base font-bold text-blue-700"></p>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">Lokasi / Tujuan</p>
                        <p id="m-lokasi" class="text-base font-bold text-gray-800"></p>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">Bil Penumpang</p>
                        <p id="m-bil" class="text-base font-bold text-gray-800"></p>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">Kod Projek</p>
                        <p id="m-kod" class="text-base font-bold text-gray-800"></p>
                    </div>
                    <div class="border-b border-gray-100 pb-2 col-span-full">
                        <p class="font-bold text-gray-400 uppercase text-[10px]">Hak Milik</p>
                        <p id="m-hak" class="text-base font-bold text-gray-800"></p>
                    </div>
                </div>
            </div>

            <div>
                <p class="font-bold text-[#1e3a8a] mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    Lampiran Dokumen
                    <span class="h-px flex-1 bg-gray-200"></span>
                </p>
                <div id="m-lampiran" class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                <p id="m-no-lampiran" class="text-sm text-gray-400 italic hidden mt-2">Tiada lampiran disertakan.</p>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100 text-center sticky bottom-0 z-10">
            <button data-modal-close class="px-12 py-3 bg-gray-900 text-white rounded-xl hover:bg-black font-bold transition-all shadow-lg hover:shadow-xl active:scale-95">
                TUTUP
            </button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

@endsection