@extends('admin_site.layout.layout')

@section('title', $tambahMode ? 'Tambah Kenderaan Baharu' : ($editKenderaan ? 'Edit Kenderaan' : 'Senarai Kenderaan'))

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-24 px-4 sm:px-6">

    <div class="mb-12 text-center">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#1e3a8a] tracking-tight mb-1">
            {{ $tambahMode ? 'Tambah Kenderaan' : ($editKenderaan ? 'Edit Kenderaan' : 'Pengurusan Kenderaan') }}
        </h1>
        <p class="text-gray-500 font-medium">
            {{ $tambahMode || $editKenderaan ? 'Sila lengkapkan maklumat teknikal kenderaan di bawah.' : 'Uruskan aset kenderaan syarikat, pantau status dan tarikh cukai jalan.' }}
        </p>
    </div>

    @if($tambahMode || $editKenderaan)
        <div class="max-w-4xl mx-auto bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-[#1e3a8a] to-blue-800 px-8 py-6 text-center">
                <h2 class="text-white font-bold text-xl tracking-wide uppercase">
                    {{ $tambahMode ? 'Daftar Kenderaan Baharu' : 'Kemaskini Maklumat Kenderaan' }}
                </h2>
            </div>

            @if($errors->any())
                <div class="mx-8 mt-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-xl text-sm font-bold">
                    {{ implode('', $errors->all(':message')) }}
                </div>
            @endif

            <form method="POST" 
                  action="{{ $tambahMode ? route('admin_site.tambah_kenderaan.store') : route('admin_site.tambah_kenderaan.update', $editKenderaan->no_pendaftaran) }}" 
                  enctype="multipart/form-data" 
                  class="p-8 md:p-10">
                @csrf
                @if($editKenderaan) <input type="hidden" name="no_pendaftaran" value="{{ $editKenderaan->no_pendaftaran }}"> @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">No. Pendaftaran</label>
                        <input type="text" name="no_pendaftaran" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50 font-bold"
                               value="{{ old('no_pendaftaran', $editKenderaan->no_pendaftaran ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Jenis Kenderaan</label>
                        <input type="text" name="jenis_kenderaan" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                               value="{{ old('jenis_kenderaan', $editKenderaan->jenis_kenderaan ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Jenama</label>
                        <input type="text" name="jenama" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                               value="{{ old('jenama', $editKenderaan->jenama ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Model</label>
                        <input type="text" name="model" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                               value="{{ old('model', $editKenderaan->model ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Warna</label>
                        <input type="text" name="warna" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50"
                               value="{{ old('warna', $editKenderaan->warna ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Kapasiti Penumpang</label>
                        <input type="number" name="kapasiti_penumpang" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50 font-bold"
                               value="{{ old('kapasiti_penumpang', $editKenderaan->kapasiti_penumpang ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Tarikh Mula Roadtax</label>
                        <input type="text" id="tarikhMulaRoadtax" name="tarikh_mula_roadtax" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50 cursor-pointer"
                               value="{{ old('tarikh_mula_roadtax', $editKenderaan->tarikh_mula_roadtax ?? '') }}" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Tarikh Tamat Roadtax</label>
                        <input type="text" id="tarikhTamatRoadtax" name="tarikh_tamat_roadtax" 
                               class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50 cursor-pointer"
                               value="{{ old('tarikh_tamat_roadtax', $editKenderaan->tarikh_tamat_roadtax ?? '') }}" required>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Status Kenderaan</label>
                        <select name="status_kenderaan" class="w-full border-2 border-gray-100 rounded-2xl px-5 py-4 text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none bg-gray-50/50 font-bold appearance-none">
                            <option value="available" {{ old('status_kenderaan', $editKenderaan->status_kenderaan ?? '') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="maintenance" {{ old('status_kenderaan', $editKenderaan->status_kenderaan ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Gambar Kenderaan</label>
                        <div class="flex flex-col sm:flex-row items-center gap-6 p-6 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200">
                            <div class="relative group">
                                <div class="w-40 h-32 rounded-2xl overflow-hidden bg-white shadow-md border-4 border-white">
                                    <img id="image-preview" 
                                         src="{{ asset($editKenderaan->gambar_kenderaan ?? 'images/profile_picture/default-profile.png') }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -top-2 -right-2 bg-blue-600 text-white p-1.5 rounded-lg shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            </div>

                            <div class="flex-1 space-y-2 text-center sm:text-left">
                                <button type="button" 
                                        onclick="this.nextElementSibling.click()"
                                        class="px-6 py-3 bg-white border border-gray-200 rounded-xl text-sm font-black text-blue-600 shadow-sm hover:bg-blue-50 transition-all active:scale-95 flex items-center gap-2 mx-auto sm:mx-0 uppercase tracking-tighter">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Pilih Fail Gambar
                                </button>
                                <input type="file" name="gambar_kenderaan" accept="image/*" class="hidden" 
                                       onchange="
                                           const file = this.files[0];
                                           if (file) {
                                               document.getElementById('{{ $tambahMode ? 'file-name-add' : 'file-name-edit' }}').textContent = file.name;
                                               const reader = new FileReader();
                                               reader.onload = function(e) {
                                                   document.getElementById('image-preview').src = e.target.result;
                                               }
                                               reader.readAsDataURL(file);
                                           }
                                       ">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest" id="{{ $tambahMode ? 'file-name-add' : 'file-name-edit' }}">Tiada fail dipilih</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex flex-col sm:flex-row gap-4 items-center justify-center border-t border-gray-100 pt-10">
                    <a href="{{ route('admin_site.senarai_kenderaan') }}" 
                       class="w-full sm:w-auto px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl hover:bg-gray-200 font-black transition-all text-sm uppercase tracking-wider text-center">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-12 py-4 bg-[#1e3a8a] text-white rounded-2xl hover:bg-black font-black transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        {{ $tambahMode ? 'Tambah Kenderaan' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>

    @else
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8 bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" id="searchKenderaan" placeholder="Cari No Pendaftaran, Jenama, atau Model..." 
                           class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 transition-all font-medium text-sm">
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin_site.tambah_kenderaan.create') }}" 
                       class="px-6 py-4 bg-[#1e3a8a] text-white rounded-2xl font-black text-sm uppercase tracking-tighter hover:bg-black transition-all shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </a>
                    <button id="deleteSelectedVehicle" disabled 
                            class="px-6 py-4 bg-red-100 text-red-600 rounded-2xl font-black text-sm uppercase tracking-tighter transition-all opacity-50 cursor-not-allowed flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Padam
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-xl font-bold flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4" id="kendContainer">
                @forelse($kenderaan as $kend)
                    <div class="vehicle-card group bg-white p-4 md:p-6 rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.02)] border border-gray-100 hover:border-blue-400 hover:shadow-[0_20px_40px_rgba(30,58,138,0.08)] transition-all duration-300 flex items-center"
                         data-no_pendaftaran="{{ $kend->no_pendaftaran }}">

                        <button data-modal-open="preview-img-{{ $kend->no_pendaftaran }}" class="relative shrink-0">
                            <img src="{{ asset($kend->gambar_kenderaan ?? 'images/profile_picture/default-profile.png') }}"
                                 class="w-20 h-16 rounded-2xl object-cover shadow-md group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute -bottom-1 -right-1 bg-blue-600 text-white p-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </button>

                        <a href="{{ route('admin_site.tambah_kenderaan.edit', $kend->no_pendaftaran) }}" 
                           class="flex-1 grid grid-cols-12 gap-4 px-6 items-center">
                            <div class="col-span-12 md:col-span-4">
                                <p class="font-black text-[#1e3a8a] text-lg leading-tight group-hover:text-blue-600 transition-colors">{{ $kend->no_pendaftaran }}</p>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $kend->jenama }} {{ $kend->model }}</p>
                            </div>
                            <div class="hidden md:block col-span-3">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis / Warna</p>
                                <p class="text-sm font-bold text-gray-700">{{ $kend->jenis_kenderaan }} ({{ $kend->warna }})</p>
                            </div>
                            <div class="hidden md:block col-span-5 text-right">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm
                                    {{ $kend->status_kenderaan == 'available' ? 'bg-green-100 text-green-600 border border-green-200' : '' }}
                                    {{ $kend->status_kenderaan == 'maintenance' ? 'bg-red-100 text-red-600 border border-red-200' : '' }}">
                                    {{ $kend->status_kenderaan }}
                                </span>
                            </div>
                        </a>

                        <div class="pl-4 border-l border-gray-100">
                            <input type="checkbox" 
                                   class="vehicleCheckbox h-6 w-6 text-red-600 rounded-xl border-2 border-gray-200 focus:ring-red-500 transition-all cursor-pointer"
                                   data-id="{{ $kend->no_pendaftaran }}">
                        </div>

                        <div id="preview-img-{{ $kend->no_pendaftaran }}" data-modal
                             class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[100] p-4">
                            <div data-modal-card class="bg-white rounded-[2.5rem] shadow-2xl p-4 w-full max-w-sm transform scale-95 opacity-0 transition-all duration-300">
                                <img src="{{ asset($kend->gambar_kenderaan ?? 'images/profile_picture/default-profile.png') }}"
                                     class="w-full h-80 rounded-[2rem] object-cover shadow-inner mb-6">
                                <button data-modal-close class="w-full py-4 bg-gray-100 text-gray-600 rounded-2xl font-black hover:bg-gray-200 transition-all uppercase tracking-widest text-xs">
                                    Tutup Pratinjau
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border-2 border-dashed border-gray-200 rounded-[3rem] py-20 px-6 text-center shadow-sm" id="noKend">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-800 mb-2">Tiada Kenderaan Dijumpai</h3>
                        <p class="text-gray-400 font-medium max-w-xs mx-auto text-sm">Sila tambah aset kenderaan baharu untuk mula menguruskan sistem.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center">
                <nav class="inline-flex gap-2 p-2 bg-white rounded-2xl shadow-sm border border-gray-100" role="navigation">
                    @if ($kenderaan->onFirstPage())
                        <span class="px-4 py-2 text-gray-300 cursor-not-allowed font-black">&larr;</span>
                    @else
                        <a href="{{ $kenderaan->previousPageUrl() }}" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-all font-black">&larr;</a>
                    @endif

                    @foreach ($kenderaan->getUrlRange(1, $kenderaan->lastPage()) as $page => $url)
                        @if ($page == $kenderaan->currentPage())
                            <span class="px-5 py-2 bg-[#1e3a8a] text-white rounded-xl font-black shadow-md">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-5 py-2 text-gray-400 hover:bg-gray-50 rounded-xl font-bold transition-all">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($kenderaan->hasMorePages())
                        <a href="{{ $kenderaan->nextPageUrl() }}" class="px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-all font-black">&rarr;</a>
                    @else
                        <span class="px-4 py-2 text-gray-300 cursor-not-allowed font-black">&rarr;</span>
                    @endif
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection