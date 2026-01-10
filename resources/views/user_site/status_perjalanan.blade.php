@extends('user_site.layout.layout')

@section('title', 'Status Perjalanan')

@section('content')
<div class="max-w-5xl mx-auto mt-10 mb-20 px-4">
    <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-4 text-[#1e3a8a] tracking-tight">
        Status Perjalanan
    </h1>
    <p class="text-center text-gray-500 mb-10 font-medium italic">Sila muat naik gambar speedometer untuk melengkapkan rekod perjalanan anda.</p>

    <div class="space-y-8">
        @forelse($senarai as $item)
            <form method="POST" action="{{ route('user_site.status_perjalanan.simpan') }}" class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100 transition-all hover:shadow-2xl" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $item->id_permohonan }}">

                <div class="bg-gradient-to-r from-[#1e3a8a] to-blue-800 px-8 py-4 flex justify-between items-center">
                    <h2 class="text-white font-bold tracking-wider uppercase text-sm md:text-base">
                        No. Pendaftaran: <span class="font-mono ml-2 text-yellow-400">{{ $item->no_pendaftaran }}</span>
                    </h2>
                    <span class="bg-white/20 text-white text-[10px] px-3 py-1 rounded-full backdrop-blur-sm font-bold uppercase">
                        Rekod Semasa
                    </span>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        <div class="lg:col-span-4 space-y-6">
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1">
                                    Tarikh Road Tax Kenderaan
                                </label>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-bold text-lg leading-none">{{ $item->kenderaan->tarikh_tamat_roadtax ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="p-1">
                                <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-3">
                                    Ulasan (Jika Ada)
                                </label>
                                <textarea name="ulasan" class="w-full border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none" rows="4" placeholder="Tulis ulasan perjalanan di sini...">{{ $item->ulasan }}</textarea>
                            </div>
                        </div>

                        <div class="lg:col-span-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                                        Speedometer Sebelum
                                    </label>
                                    <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-2 hover:border-blue-400 transition-colors bg-gray-50/50">
                                        <div class="aspect-video w-full rounded-xl overflow-hidden bg-gray-200 relative mb-2">
                                            <img id="preview-sebelum-{{ $item->id_permohonan }}" src="{{ $item->speedometer_sebelum ? asset('storage/'.$item->speedometer_sebelum) : 'https://placehold.co/600x400?text=Sila+Muat+Naik' }}" class="speedometer-preview w-full h-full object-cover cursor-pointer" data-modal-img="{{ $item->speedometer_sebelum ? asset('storage/'.$item->speedometer_sebelum) : '' }}">
                                        </div>
                                        <input type="file" name="speedometer_sebelum" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        @if($item->speedometer_sebelum)
                                            <p class="text-[10px] text-green-600 font-bold mt-1">✔ Telah dimuat naik</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-widest">
                                        Speedometer Selepas
                                    </label>
                                    <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-2 hover:border-blue-400 transition-colors bg-gray-50/50">
                                        <div class="aspect-video w-full rounded-xl overflow-hidden bg-gray-200 relative mb-2">
                                            <img id="preview-selepas-{{ $item->id_permohonan }}" src="{{ $item->speedometer_selepas ? asset('storage/'.$item->speedometer_selepas) : 'https://placehold.co/600x400?text=Sila+Muat+Naik' }}" class="speedometer-preview w-full h-full object-cover cursor-pointer" data-modal-img="{{ $item->speedometer_selepas ? asset('storage/'.$item->speedometer_selepas) : '' }}">
                                        </div>
                                        <input type="file" name="speedometer_selepas" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                        @if($item->speedometer_selepas)
                                            <p class="text-[10px] text-green-600 font-bold mt-1">✔ Telah dimuat naik</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="px-10 py-3 bg-[#1e3a8a] text-white rounded-xl hover:bg-black font-extrabold transition-all shadow-lg hover:shadow-xl active:scale-95 flex items-center gap-2 uppercase tracking-wider">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Rekod
                    </button>
                </div>
            </form>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl py-24 text-center">
                <p class="text-gray-400 font-bold text-lg">Tiada perjalanan direkodkan buat masa ini.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="modalSpeedometer" class="fixed inset-0 z-[100] hidden bg-black/90 flex items-center justify-center p-4">
    <button type="button" class="absolute top-5 right-5 text-white text-5xl hover:text-gray-300 transition-colors">&times;</button>
    <img id="modalSpeedometerImg" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl border-4 border-white/10">
</div>
@endsection