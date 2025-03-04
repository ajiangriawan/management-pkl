@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Jurnal Harian</h1>

    <form action="{{ route('siswa.journal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="block text-gray-700 font-bold mt-4">Isi Jurnal:</label>
        <textarea name="isi" class="border rounded-lg w-full p-2" required></textarea>

        <label class="block text-gray-700 font-bold mt-4">Foto (Opsional):</label>
        <input type="file" name="foto" class="border rounded-lg w-full p-2">

        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg mt-4 w-full">Simpan</button>
    </form>
</div>
@endsection
