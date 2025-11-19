@extends('admin_site.layout.layout')

@section('title', $tambahMode ? 'Tambah Pengguna Baharu' : ($editUser ? 'Edit Pengguna' : 'Senarai Pengguna'))

@section('content')

@if($tambahMode)
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Tambah Pengguna Baharu</h2>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ implode('', $errors->all(':message')) }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin_site.tambah_pengguna.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="flex flex-col gap-4">
            <div class="flex-1">
                <label class="block font-medium text-gray-700">ID Pekerja</label>
                <input type="text" name="id_pekerja" class="w-full border rounded-lg p-2" maxlength="50" required value="{{ old('id_pekerja') }}">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" class="w-full border rounded-lg p-2" maxlength="255" value="{{ old('nama') }}">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Jawatan</label>
                <input type="text" name="jawatan" class="w-full border rounded-lg p-2" maxlength="255" value="{{ old('jawatan') }}">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg p-2" value="{{ old('email') }}">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">No. Telefon</label>
                <input type="tel" name="no_tel" class="w-full border rounded-lg p-2" maxlength="20" value="{{ old('no_tel') }}">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Kata Laluan</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700 mb-1">Gambar Profil (Optional)</label>
                <div class="flex flex-row items-center">
                    <div class="w-60 border rounded-lg p-2 cursor-pointer flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition"
                    onclick="this.nextElementSibling.click()">
                        <span>Upload Gambar</span>
                    </div>
                    <input type="file" name="gambar_profil" accept="image/*" class="hidden" 
                    onchange="document.getElementById('file-name-add').textContent = this.files[0]?.name || ''" >
                    <span class="ml-2 text-gray-600" id="file-name-add"></span>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Tambah Pengguna
        </button>
        <a href="{{ route('admin_site.senarai_pengguna') }}" class="text-gray-500 ml-3 hover:underline">Batal</a>
    </form>

@elseif($editUser)
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Edit Pengguna</h2>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ implode('', $errors->all(':message')) }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin_site.tambah_pengguna.update', $editUser->id_pekerja) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="id" value="{{ $editUser->id }}">

        <div class="flex flex-col gap-4">
            <div class="flex-1">
                <label class="block font-medium text-gray-700">ID Pekerja</label>
                <input type="text" name="id_pekerja" value="{{ old('id_pekerja', $editUser->id_pekerja) }}" class="w-full border rounded-lg p-2" maxlength="50" required>
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $editUser->nama) }}" class="w-full border rounded-lg p-2" maxlength="255">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Jawatan</label>
                <input type="text" name="jawatan" value="{{ old('jawatan', $editUser->jawatan) }}" class="w-full border rounded-lg p-2" maxlength="255">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $editUser->email) }}" class="w-full border rounded-lg p-2">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">No. Telefon</label>
                <input type="tel" name="no_tel" value="{{ old('no_tel', $editUser->no_tel) }}" class="w-full border rounded-lg p-2" maxlength="20">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Tukar Kata Laluan (Optional)</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2">
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700 mb-1">Gambar Profil (Optional)</label>
                <div class="flex flex-row items-center">
                    <div class="w-60 border rounded-lg p-2 cursor-pointer flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition"
                    onclick="this.nextElementSibling.click()">
                        <span>Upload Gambar</span>
                    </div>
                    <input type="file" name="gambar_profil" accept="image/*" class="hidden" 
                    onchange="document.getElementById('file-name-edit').textContent = this.files[0]?.name || ''">
                    <span class="ml-2 text-gray-600" id="file-name-edit"></span>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Simpan Perubahan
        </button>
        <a href="{{ route('admin_site.senarai_pengguna') }}" class="text-gray-500 ml-3 hover:underline">Batal Edit</a>
    </form>

@else
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-center md:gap-4">
        <h2 class="text-2xl font-bold text-gray-700 text-center md:text-left flex-1">Senarai Pengguna</h2>
        <div class="flex gap-2 justify-center flex-1 md:flex-none">
            <input type="text" id="searchUser" placeholder="Cari pengguna..." class="border rounded-lg p-2 w-48 focus:outline-blue-500">
            <a href="{{ route('admin_site.tambah_pengguna.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Tambah Pengguna
            </a>
            <button id="deleteSelected" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition opacity-50 cursor-not-allowed" disabled>
                Padam Pengguna
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md p-4 max-h-[55vh] overflow-y-auto space-y-4" id="userContainer">

        @forelse($users as $user)
            <div class="user-card group flex items-center justify-between p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all border border-gray-200">

                {{-- PROFILE IMAGE --}}
                <button data-modal-open="preview-img-{{ $user->id_pekerja }}">
                    <img
                        src="{{ asset($user->gambar_profil ?? 'images/profile_picture/default-profile.png') }}"
                        class="w-12 h-12 rounded-full object-cover shadow-md mr-4 hover:scale-105 transition"
                    >
                </button>

                {{-- USER INFO --}}
                <a href="{{ route('admin_site.tambah_pengguna.edit', $user->id_pekerja) }}"
                class="flex-1 grid grid-cols-13 gap-6 pl-4 text-sm">

                    {{-- ID --}}
                    <div class="col-span-2 font-semibold text-gray-900 truncate">
                        {{ $user->id_pekerja }}
                    </div>

                    {{-- NAMA --}}
                    <div class="col-span-4 font-semibold text-gray-800 truncate">
                        {{ $user->nama }}
                    </div>

                    {{-- JAWATAN --}}
                    <div class="col-span-2 text-gray-600 truncate">
                        {{ $user->jawatan ?? '-' }}
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-span-3 text-gray-500 truncate">
                        {{ $user->email }}
                    </div>

                    {{-- NO TEL --}}
                    <div class="col-span-2 text-gray-500 truncate">
                        {{ $user->no_tel ?? '-' }}
                    </div>

                </a>

                {{-- CHECKBOX --}}
                <div class="pl-6 pr-4">
                    <input
                        type="checkbox"
                        class="userCheckbox h-5 w-5 text-red-600 rounded focus:ring-red-500"
                        data-id="{{ $user->id_pekerja }}"
                    >
                </div>

                {{-- PROFILE PHOTO MODAL --}}
                <div id="preview-img-{{ $user->id_pekerja }}" data-modal
                    class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">

                    <div data-modal-card
                        class="bg-white rounded-2xl shadow-2xl p-3 w-[90%] max-w-md transform scale-95 opacity-0 transition-all duration-200">

                        <img src="{{ asset($user->gambar_profil ?? 'images/profile_picture/default-profile.png') }}"
                            class="w-full rounded-xl object-cover shadow-md">

                        <div class="flex justify-center mt-3">
                            <button data-modal-close
                                class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Tutup
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        @empty

            <p class="text-gray-500 py-4 text-center" id="noUser">Tiada pengguna dijumpai.</p>

        @endforelse

        <p class="text-gray-500 hidden py-4 text-center" id="noMatch">
            Tiada pengguna sepadan dengan carian.
        </p>
    </div>

    <div class="mt-4 flex justify-center">
        <nav class="inline-flex rounded-md shadow-sm" role="navigation">
            {{-- Previous --}}
            @if ($users->onFirstPage())
                <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&laquo;</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 text-gray-600 hover:bg-blue-100 rounded">&laquo;</a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if ($page == $users->currentPage())
                    <span class="px-3 py-1 mx-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1 mx-1 text-gray-500 bg-gray-100 hover:bg-gray-200 rounded opacity-60">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 text-gray-600 hover:bg-blue-100 rounded">&raquo;</a>
            @else
                <span class="px-3 py-1 text-gray-400 cursor-not-allowed">&raquo;</span>
            @endif
        </nav>
    </div>


@endif

@endsection
