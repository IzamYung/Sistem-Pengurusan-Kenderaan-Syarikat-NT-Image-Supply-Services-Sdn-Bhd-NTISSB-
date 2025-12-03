@extends('admin_site.layout.layout')

@section('title', $tambahMode ? 'Tambah Kenderaan Baharu' : ($editKenderaan ? 'Edit Kenderaan' : 'Senarai Kenderaan'))

@section('content')

@if($tambahMode)
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Tambah Kenderaan Baharu</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ implode('', $errors->all(':message')) }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin_site.tambah_kenderaan.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700">No Pendaftaran</label>
                <input type="text" name="no_pendaftaran" class="w-full border rounded-lg p-2" value="{{ old('no_pendaftaran') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Jenis Kenderaan</label>
                <input type="text" name="jenis_kenderaan" class="w-full border rounded-lg p-2" value="{{ old('jenis_kenderaan') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Jenama</label>
                <input type="text" name="jenama" class="w-full border rounded-lg p-2" value="{{ old('jenama') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Model</label>
                <input type="text" name="model" class="w-full border rounded-lg p-2" value="{{ old('model') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Warna</label>
                <input type="text" name="warna" class="w-full border rounded-lg p-2" value="{{ old('warna') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Kapasiti Penumpang</label>
                <input type="number" name="kapasiti_penumpang" class="w-full border rounded-lg p-2" value="{{ old('kapasiti_penumpang') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Tarikh Mula Roadtax</label>
                <input type="date" name="tarikh_mula_roadtax" class="w-full border rounded-lg p-2" value="{{ old('tarikh_mula_roadtax') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Tarikh Tamat Roadtax</label>
                <input type="date" name="tarikh_tamat_roadtax" class="w-full border rounded-lg p-2" value="{{ old('tarikh_tamat_roadtax') }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Status</label>
                <select name="status_kenderaan" class="w-full border rounded-lg p-2">
                    <option value="available" {{ old('status_kenderaan') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="in_use" {{ old('status_kenderaan') == 'in_use' ? 'selected' : '' }}>In Use</option>
                    <option value="maintenance" {{ old('status_kenderaan') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block font-medium text-gray-700 mb-1">Gambar Kenderaan (Optional)</label>
                <div class="flex items-center gap-2">
                    <div class="w-60 border rounded-lg p-2 cursor-pointer flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition"
                         onclick="this.nextElementSibling.click()">
                        <span>Upload Gambar</span>
                    </div>
                    <input type="file" name="gambar_kenderaan" accept="image/*" class="hidden"
                           onchange="document.getElementById('file-name-add').textContent = this.files[0]?.name || ''">
                    <span class="text-gray-600" id="file-name-add"></span>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Tambah Kenderaan</button>
            <a href="{{ route('admin_site.senarai_kenderaan') }}" class="text-gray-500 ml-3 hover:underline">Batal</a>
        </div>
    </form>

@elseif($editKenderaan)
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Edit Kenderaan</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ implode('', $errors->all(':message')) }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin_site.tambah_kenderaan.update', $editKenderaan->no_pendaftaran) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="no_pendaftaran" value="{{ $editKenderaan->no_pendaftaran }}">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-gray-700">No Pendaftaran</label>
                <input type="text" name="no_pendaftaran" class="w-full border rounded-lg p-2" value="{{ old('no_pendaftaran', $editKenderaan->no_pendaftaran) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Jenis Kenderaan</label>
                <input type="text" name="jenis_kenderaan" class="w-full border rounded-lg p-2" value="{{ old('jenis_kenderaan', $editKenderaan->jenis_kenderaan) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Jenama</label>
                <input type="text" name="jenama" class="w-full border rounded-lg p-2" value="{{ old('jenama', $editKenderaan->jenama) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Model</label>
                <input type="text" name="model" class="w-full border rounded-lg p-2" value="{{ old('model', $editKenderaan->model) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Warna</label>
                <input type="text" name="warna" class="w-full border rounded-lg p-2" value="{{ old('warna', $editKenderaan->warna) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Kapasiti Penumpang</label>
                <input type="number" name="kapasiti_penumpang" class="w-full border rounded-lg p-2" value="{{ old('kapasiti_penumpang', $editKenderaan->kapasiti_penumpang) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Tarikh Mula Roadtax</label>
                <input type="date" name="tarikh_mula_roadtax" class="w-full border rounded-lg p-2" value="{{ old('tarikh_mula_roadtax', $editKenderaan->tarikh_mula_roadtax) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Tarikh Tamat Roadtax</label>
                <input type="date" name="tarikh_tamat_roadtax" class="w-full border rounded-lg p-2" value="{{ old('tarikh_tamat_roadtax', $editKenderaan->tarikh_tamat_roadtax) }}" required>
            </div>
            <div>
                <label class="block font-medium text-gray-700">Status</label>
                <select name="status_kenderaan" class="w-full border rounded-lg p-2">
                    <option value="available" {{ $editKenderaan->status_kenderaan == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="in_use" {{ $editKenderaan->status_kenderaan == 'in_use' ? 'selected' : '' }}>In Use</option>
                    <option value="maintenance" {{ $editKenderaan->status_kenderaan == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block font-medium text-gray-700 mb-1">Gambar Kenderaan (Optional)</label>
                <div class="flex items-center gap-2">
                    <div class="w-60 border rounded-lg p-2 cursor-pointer flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition"
                         onclick="this.nextElementSibling.click()">
                        <span>Upload Gambar</span>
                    </div>
                    <input type="file" name="gambar_kenderaan" accept="image/*" class="hidden"
                           onchange="document.getElementById('file-name-edit').textContent = this.files[0]?.name || ''">
                    <span class="text-gray-600" id="file-name-edit"></span>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
            <a href="{{ route('admin_site.senarai_kenderaan') }}" class="text-gray-500 ml-3 hover:underline">Batal Edit</a>
        </div>
    </form>

@else
    {{-- Senarai Kenderaan --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-center md:gap-4">
        <h2 class="text-2xl font-bold text-gray-700 text-center md:text-left flex-1">Senarai Kenderaan</h2>
        <div class="flex gap-2 justify-center flex-1 md:flex-none">
            <input type="text" id="searchKenderaan" placeholder="Cari kenderaan..." class="border rounded-lg p-2 w-48 focus:outline-blue-500">
            <a href="{{ route('admin_site.tambah_kenderaan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Tambah Kenderaan</a>
            <button id="deleteSelectedVehicle" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition opacity-50 cursor-not-allowed" disabled>Padam Kenderaan</button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md p-4 max-h-[55vh] overflow-y-auto space-y-4" id="kendContainer">
        @forelse($kenderaan as $kend)
            <div class="vehicle-card group flex items-center justify-between p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all border border-gray-200" data-no_pendaftaran="{{ $kend->no_pendaftaran }}">
                
                <button data-modal-open="preview-img-{{ $kend->no_pendaftaran }}">
                    <img src="{{ asset($kend->gambar_kenderaan ?? 'images/profile_picture/default-profile.png') }}"
                         class="w-12 h-12 rounded-full object-cover shadow-md mr-4 hover:scale-105 transition">
                </button>

                <a href="{{ route('admin_site.tambah_kenderaan.edit', $kend->no_pendaftaran) }}" class="flex-1 grid grid-cols-7 gap-4 pl-4 text-sm">
                    <div class="col-span-2 font-semibold text-gray-900 truncate">{{ $kend->no_pendaftaran }}</div>
                    <div class="col-span-2 font-semibold text-gray-800 truncate">{{ $kend->jenama }} {{ $kend->model }}</div>
                    <div class="col-span-1 text-gray-600 truncate">{{ $kend->jenis_kenderaan }}</div>
                    <div class="col-span-1 text-gray-500 truncate">{{ $kend->warna }}</div>
                    <div class="col-span-1 text-gray-500 truncate">{{ $kend->status_kenderaan }}</div>
                </a>

                <div class="pl-6 pr-4">
                    <input type="checkbox" class="vehicleCheckbox h-5 w-5 text-red-600 rounded focus:ring-red-500" data-id="{{ $kend->no_pendaftaran }}">
                </div>

                {{-- IMAGE PREVIEW MODAL --}}
                <div id="preview-img-{{ $kend->no_pendaftaran }}" data-modal
                     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">

                    <div data-modal-card class="bg-white rounded-2xl shadow-2xl p-4 w-[90%] max-w-md transform scale-95 opacity-0 transition-all duration-200">
                        <img src="{{ asset($kend->gambar_kenderaan ?? 'images/profile_picture/default-profile.png') }}"
                             class="w-full rounded-xl object-cover shadow-md">

                        <div class="flex justify-center mt-3">
                            <button data-modal-close class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Tutup</button>
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <p class="text-gray-500 py-4 text-center" id="noKend">Tiada kenderaan dijumpai.</p>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 flex justify-center">
        <nav class="inline-flex rounded-md shadow-sm" role="navigation">
            @if ($kenderaan->onFirstPage())
                <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&laquo;</span>
            @else
                <a href="{{ $kenderaan->previousPageUrl() }}" class="px-3 py-1 text-gray-600 hover:bg-blue-100 rounded">&laquo;</a>
            @endif

            @foreach ($kenderaan->getUrlRange(1, $kenderaan->lastPage()) as $page => $url)
                @if ($page == $kenderaan->currentPage())
                    <span class="px-3 py-1 mx-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 mx-1 text-gray-500 bg-gray-100 hover:bg-gray-200 rounded opacity-60">{{ $page }}</a>
                @endif
            @endforeach

            @if ($kenderaan->hasMorePages())
                <a href="{{ $kenderaan->nextPageUrl() }}" class="px-3 py-1 text-gray-600 hover:bg-blue-100 rounded">&raquo;</a>
            @else
                <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&raquo;</span>
            @endif
        </nav>
    </div>
@endif

@endsection
