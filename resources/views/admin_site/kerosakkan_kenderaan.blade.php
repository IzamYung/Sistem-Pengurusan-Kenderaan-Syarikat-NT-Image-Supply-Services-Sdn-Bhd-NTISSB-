@extends('admin_site.layout.layout')

@section('title', 'Kerosakan Kenderaan')

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-24 px-4 sm:px-6">
    @if($action === 'add')
        {{-- =================== FORM TAMBAH LAPORAN =================== --}}
        <div class="max-w-3xl mx-auto bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-[#1e3a8a] to-blue-800 px-8 py-6 text-center">
                <h2 class="text-white font-bold text-xl tracking-wide uppercase">Tambah Laporan Kerosakan</h2>
            </div>

            <form action="{{ route('admin_site.kerosakkan_kenderaan.store') }}" method="POST" class="p-8 md:p-10">
                @csrf
                <div class="grid gap-6">
                    {{-- No Pendaftaran --}}
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

                    {{-- Jenis Kerosakan --}}
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Jenis Kerosakan</label>
                        <input type="text" name="jenis_kerosakan" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                               placeholder="Contoh: Lampu Depan Pecah / Masalah Enjin" required>
                    </div>

                    {{-- Ulasan --}}
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
    @else
        <div class="mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-1 text-[#1e3a8a] tracking-tight">
                Laporan Kerosakan
            </h1>
            <p class="text-gray-500 mb-5 font-medium">Pantau dan uruskan rekod kerosakan kenderaan jabatan secara sistematik.</p>
        </div>
        {{-- BUTTON TAMBAH LAPORAN --}}
        <div class="flex justify-end max-w-5xl mx-auto mb-8">
            <a href="{{ route('admin_site.kerosakkan_kenderaan', ['action' => 'add']) }}"
            class="group px-6 py-4 bg-[#1e3a8a] text-white rounded-2xl shadow-xl hover:bg-black transition-all duration-300 flex items-center gap-3 active:scale-95">
                <span class="font-black uppercase tracking-tighter text-sm">Tambah Laporan Baru</span>
                <div class="bg-white/20 p-1.5 rounded-lg group-hover:bg-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                </div>
            </a>
        </div>

        {{-- ================== SENARAI ================== --}}
        <div class="max-w-5xl mx-auto space-y-5">
            @forelse($senarai as $item)
            <div
                data-modal-open="modalPermohonan"
                data-id="{{ $item->id_laporan }}"
                data-no="{{ $item->no_pendaftaran }}"
                data-model="{{ $item->kenderaan->model ?? '-' }}"
                data-tarikh="{{ \Carbon\Carbon::parse($item->tarikh_laporan)->format('d/m/Y') }}"
                data-jenis="{{ $item->jenis_kerosakan }}"
                data-ulasan="{{ $item->ulasan ?? '-' }}"
                class="group bg-white p-6 md:p-8 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.03)] border border-gray-100 hover:border-blue-400 hover:shadow-[0_20px_40px_rgba(30,58,138,0.1)] cursor-pointer transition-all duration-300 flex flex-col md:flex-row justify-between items-center gap-6">

                <div class="flex items-center gap-6 w-full md:w-auto">
                    <div class="bg-blue-50 p-4 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
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

                <div class="flex flex-row md:flex-col items-center md:items-end justify-between w-full md:w-auto border-t md:border-0 pt-4 md:pt-0 border-gray-100">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tarikh Laporan</p>
                    <p class="font-extrabold text-lg text-gray-700">
                        {{ \Carbon\Carbon::parse($item->tarikh_laporan)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            @empty
            {{-- EMPTY STATE --}}
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

{{-- ================= MODAL DETAIL ================= --}}
<div id="modalPermohonan" class="fixed inset-0 z-[100] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300 border border-gray-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-[#1e3a8a] tracking-tight">
                Maklumat Laporan Kerosakan
            </h2>
        </div>

        <div class="space-y-4 bg-gray-50 p-6 rounded-3xl border border-gray-100">
            <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">No Pendaftaran</span>
                <span id="m-no" class="font-bold text-gray-800">-</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Model Kenderaan</span>
                <span id="m-model" class="font-bold text-gray-800">-</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis Kerosakan</span>
                <span id="m-jenis" class="font-bold text-red-600">-</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tarikh Laporan</span>
                <span id="m-tarikh" class="font-bold text-gray-800">-</span>
            </div>
            <div class="py-2">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Ulasan / Catatan</span>
                <p id="m-ulasan" class="text-sm text-gray-600 bg-white p-4 rounded-xl border border-gray-200">-</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <form id="formSelesai" method="POST" class="w-full sm:w-auto">
                @csrf
                <button class="w-full px-10 py-4 bg-green-600 text-white rounded-2xl font-black shadow-lg hover:bg-green-700 transition-all active:scale-95 text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    Selesai
                </button>
            </form>
            <button data-modal-close class="w-full sm:w-auto px-10 py-4 bg-gray-200 text-gray-600 rounded-2xl font-black hover:bg-gray-300 transition-all text-sm uppercase tracking-wider">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection