@extends('user_site.layout.layout')

@section('title')
    @if(isset($page) && $page === 'borang')
        Borang Permohonan
    @else
        Halaman Utama
    @endif
@endsection

@section('content')

<style>
    .upload-container {
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 2rem;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        padding: 0.75rem 1rem;
        border-radius: 1.25rem;
        margin-top: 0.5rem;
        border: 1px solid #edf2f7;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .file-name-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        flex: 1;
    }

    .file-name-text {
        font-size: 0.875rem;
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-ext-text {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e3a8a;
    }

    .remove-btn {
        margin-left: 0.75rem;
        color: #ef4444;
        background: #fef2f2;
        padding: 0.4rem;
        border-radius: 0.75rem;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .remove-btn:hover {
        background: #ef4444;
        color: white;
    }
</style>

@if(isset($page) && $page === 'borang')
    <script>
        window.bookedDates = @json($bookedDates ?? []);
    </script>

    <div class="max-w-4xl mx-auto mt-10 mb-20 px-4">
        <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-gray-100">
            <div class="bg-[#1e3a8a] py-12 px-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
                <h2 class="text-3xl font-black text-white text-center tracking-[0.2em] uppercase relative z-10">Borang Permohonan</h2>
                <p class="text-blue-200 text-center text-xs mt-3 uppercase tracking-[0.3em] font-bold relative z-10">Sistem Pengurusan Kenderaan</p>
            </div>

            <form method="POST" action="{{ route('user_site.permohonan.store') }}" enctype="multipart/form-data" class="p-8 md:p-14 space-y-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-8 rounded-[2.5rem] border border-gray-100">
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">No. Pendaftaran</label>
                        <p class="text-lg font-bold text-[#1e3a8a]">{{ $kenderaan->no_pendaftaran ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Model Kenderaan</label>
                        <p class="text-lg font-bold text-[#1e3a8a]">{{ $kenderaan->model ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Pemohon</label>
                        <p class="text-lg font-bold text-[#1e3a8a]">{{ $user->nama ?? '-' }}</p>
                    </div>
                </div>

                <input type="hidden" name="no_pendaftaran" value="{{ $kenderaan->no_pendaftaran ?? '' }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-gray-700 mb-3 ml-2 uppercase tracking-widest">Tarikh & Masa Pelepasan <span class="text-red-500">*</span></label>
                        <input type="text" name="tarikh_pelepasan" id="tarikhPelepasan" value="{{ old('tarikh_pelepasan') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all outline-none font-bold text-gray-700" required autocomplete="off" placeholder="Pilih tarikh..."/>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-gray-700 mb-3 ml-2 uppercase tracking-widest">Lokasi / Tujuan <span class="text-red-500">*</span></label>
                        <input type="text" name="lokasi" required value="{{ old('lokasi') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all outline-none font-bold text-gray-700" placeholder="Contoh: Mesyuarat Tapak di Melaka" />
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-700 mb-3 ml-2 uppercase tracking-widest">Bilangan Penumpang <span class="text-red-500">*</span></label>
                        <input type="number" min="1" name="bil_penumpang" value="{{ old('bil_penumpang') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white @error('bil_penumpang') border-red-500 @enderror transition-all outline-none font-bold text-gray-700" required placeholder="0" />
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-700 mb-3 ml-2 uppercase tracking-widest">Kod Projek <span class="text-red-500">*</span></label>
                        <input type="text" name="kod_projek" required value="{{ old('kod_projek') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all outline-none font-bold text-gray-700" placeholder="Masukkan kod projek" />
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-700 mb-3 ml-2 uppercase tracking-widest">Hak Milik <span class="text-red-500">*</span></label>
                        <input type="text" name="hak_milik" required value="{{ old('hak_milik') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-blue-50 focus:border-[#1e3a8a] focus:bg-white transition-all outline-none font-bold text-gray-700" placeholder="Nama pemilik/jabatan" />
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-700 mb-3 ml-2 uppercase tracking-widest">Lampiran Dokumen</label>
                        <div class="upload-container">
                            <input type="file" id="lampiranInput" name="lampiran[]" multiple class="hidden" />
                            <label for="lampiranInput" class="flex items-center gap-4 p-4 border-2 border-dashed border-gray-200 rounded-[1.5rem] cursor-pointer hover:border-[#1e3a8a] hover:bg-white transition-all group">
                                <div class="bg-blue-50 group-hover:bg-[#1e3a8a] p-3 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#1e3a8a] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-black text-[#1e3a8a] uppercase tracking-widest">Muat Naik Fail</p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase">Klik untuk pilih dokumen</p>
                                </div>
                            </label>
                            <div id="lampiranList" class="mt-2 empty:hidden"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-10">
                    <button type="submit" class="w-full py-6 bg-[#1e3a8a] hover:bg-blue-800 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.3em] shadow-xl shadow-blue-100 transform active:scale-[0.98] transition-all">
                        Hantar Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>

@else

    <div class="mb-12 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-1 text-[#1e3a8a] tracking-tight">
            Senarai Kenderaan Syarikat
        </h1>
        <p class="text-gray-500 mb-5 font-medium">Sila pilih kenderaan di bawah untuk melakukan permohonan.</p>
    </div>

    <div class="max-w-4xl mx-auto mt-10 px-4 mb-20">
        <form method="GET" class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-6">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-2 block ml-2">Carian Model / No. Plat</label>
                    <input type="text" id="searchKenderaan" name="search" value="{{ request('search') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-5 py-3.5 focus:border-[#1e3a8a] focus:bg-white transition-all outline-none text-sm font-bold" placeholder="Cari kenderaan..." />
                </div>

                <div class="md:col-span-3">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-2 block ml-2">Jenama</label>
                    <select name="jenama" onchange="this.form.submit()" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-4 py-3.5 focus:border-[#1e3a8a] outline-none cursor-pointer text-sm font-bold">
                        <option value="">Semua</option>
                        @foreach($jenamaList as $brand)
                            <option value="{{ $brand }}" {{ strtolower(request('jenama')) == strtolower($brand) ? 'selected' : '' }}>
                                {{ ucfirst($brand) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="text-[10px] font-bold text-gray-400 uppercase mb-2 block ml-2">Kapasiti</label>
                    <input type="number" name="kapasiti" value="{{ request('kapasiti') }}" class="w-full border-2 border-gray-100 bg-gray-50 rounded-2xl px-4 py-3.5 focus:border-[#1e3a8a] outline-none text-sm font-bold" placeholder="Min: 1" />
                </div>
            </div>
        </form>

        <div class="flex items-center justify-between mb-8 px-2">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center">
                <span class="w-8 h-[2px] bg-[#1e3a8a] mr-3"></span> Unit Kenderaan Tersedia
            </h2>
        </div>

        <div class="flex flex-col gap-8" id="vehicleList">
            @forelse ($kenderaan ?? [] as $car)
                @php
                    $isAvailable = strtolower($car->status_kenderaan) === 'available';
                    $roadtax = ($car->tarikh_tamat_roadtax) 
                                ? \Carbon\Carbon::parse($car->tarikh_tamat_roadtax)->format('d/m/Y') 
                                : '-';
                @endphp

                <a
                    @if($isAvailable)
                        href="{{ route('user_site.permohonan.borang', ['no_pendaftaran' => $car->no_pendaftaran]) }}"
                    @else
                        href="javascript:void(0)"
                    @endif
                    class="vehicle-card group relative flex flex-col md:flex-row bg-white rounded-[2.5rem] overflow-hidden border-2 border-transparent transition-all duration-500
                    {{ $isAvailable
                        ? 'hover:border-[#1e3a8a] hover:shadow-2xl shadow-lg shadow-gray-100'
                        : 'opacity-50 grayscale cursor-not-allowed pointer-events-none'
                    }}"
                    data-name="{{ strtolower($car->model) }}"
                    data-no_pendaftaran="{{ strtolower($car->no_pendaftaran) }}"
                    data-jenama="{{ strtolower($car->jenama) }}"
                    data-kapasiti="{{ $car->kapasiti_penumpang ?? 0 }}"
                    data-kategori="{{ strtolower($car->jenis_kenderaan) }}"
                >
                    <div class="w-full md:w-80 h-64 md:h-auto overflow-hidden relative bg-gray-50">
                        <img src="{{ asset($car->gambar_kenderaan) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur-md text-[#1e3a8a] text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-tighter shadow-sm border border-white/50">
                                {{ $car->jenis_kenderaan }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 md:p-10 flex-1 flex flex-col">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-3xl font-black text-[#1e3a8a] tracking-tight uppercase group-hover:text-blue-800 transition-colors">
                                    {{ $car->model }}
                                </h3>
                                <p class="text-gray-400 font-bold text-sm tracking-widest mt-1">{{ $car->no_pendaftaran }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">{{ $car->jenama }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-10 pt-8 border-t border-gray-50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#1e3a8a]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Kapasiti</p>
                                    <p class="text-sm font-bold text-gray-700">{{ $car->kapasiti_penumpang ?? 0 }} Orang</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#1e3a8a]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">Roadtax Sah</p>
                                    <p class="text-sm font-bold text-gray-700">{{ $roadtax }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute bottom-8 right-8">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300 transition-all duration-300 group-hover:bg-[#1e3a8a] group-hover:text-white group-hover:rotate-[-45deg] shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Tiada rekod kenderaan ditemui</p>
                </div>
            @endforelse
        </div>

        <p id="noMatchVehicle" class="hidden text-center py-20 text-gray-400 font-bold uppercase tracking-widest text-xs">
            Tiada padanan ditemui. Cuba kata kunci lain.
        </p>
        <p id="noVehicle" class="hidden text-center py-20 text-gray-400 font-bold uppercase tracking-widest text-xs">
            Tiada kenderaan buat masa ini.
        </p>
    </div>
@endif

@endsection