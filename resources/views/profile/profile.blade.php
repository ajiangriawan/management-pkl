@extends('layouts.app')
@section('title', 'Profile')
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
        <div>
            <label for="name" class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ $profile->nama }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" disabled>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" value="{{ $profile->telepon ?? '' }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" >
        </div>
        @endif

        <div>
            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" disabled>
        </div>
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" disabled>{{ $profile->alamat }}</textarea>
        </div>

       
        <div class="grid">
            <a href="{{ route('profile.edit') }}" class="col-end text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Edit Profil
            </a>
        </div>
    </form>
</div>
@endsection