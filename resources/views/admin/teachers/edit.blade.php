@extends('layouts.app')
@section('title', 'Edit Guru Pembimbing')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <h3 class="text-center text-2xl font-bold text-blue-600 mb-6">Edit Guru Pembimbing</h3>

        <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- nip -->
                <div>
                    <label for="nip" class="block text-gray-700 font-semibold mb-1">nip</label>
                    <input type="number" id="nip" name="nip" required value="{{ old('nip', $teacher->nip) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nip') border-red-500 @enderror">
                    @error('nip')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required value="{{ old('nama', $teacher->nama) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror">
                    @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" id="email" name="email" required value="{{ old('email', $teacher->email) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="telepon" class="block text-gray-700 font-semibold mb-1">Nomor Telepon</label>
                    <input type="number" id="telepon" name="telepon" required value="{{ old('telepon', $teacher->telepon) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('telepon') border-red-500 @enderror">
                    @error('telepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-gray-700 font-semibold mb-1">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" required
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('alamat') border-red-500 @enderror">{{ old('alamat', $teacher->alamat) }}</textarea>
                    @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.teachers') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection