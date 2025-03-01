@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Profil Saya</h2>
    <div class="flex items-center space-x-6">
        <!-- $profile->profile_photo -->
        <img src="{{ asset('images/logo.png') ?? 'https://via.placeholder.com/150' }}"
            alt="Profile Picture"
            class="w-24 h-24 rounded-full border-4 border-blue-500">
        <div>
            <h3 class="text-xl font-semibold text-gray-700">{{ $profile->nama ?? 'Nama Tidak Diketahui' }}</h3>
            <p class="text-gray-500">{{ $user->email }}</p>
            <span class="px-3 py-1 bg-green-100 text-green-600 text-sm rounded-md">{{ ucfirst($user->role) }}</span>
        </div>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        @method('PATCH')

        @if ($profile)
        @if ($user->role === 'Siswa')
        <div>
            <label for="nisn" class="block text-sm font-medium text-gray-600">NISN</label>
            <input type="text" id="nisn" name="nisn" value="{{ $profile->nisn }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        @else
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-600">NIP</label>
            <input type="text" id="nip" name="nip" value="{{ $profile->nip }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        @endif
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="{{ $profile->nama }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="telepon" class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
            <input type="text" id="telepon" name="telepon" value="{{ $profile->telepon ?? '' }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        @endif

        <div>
            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $profile->alamat }}</textarea>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-600">Password Baru</label>
            <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">

        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection