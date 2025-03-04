@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Jurnal Harian</h1>

    <a href="{{ route('siswa.journal.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Tambah Jurnal</a>

    <div class="mt-4">
        @foreach ($journals as $journal)
            <div class="border p-4 rounded-lg mb-2 bg-gray-100">
                <p><strong>Tanggal:</strong> {{ $journal->tanggal }}</p>
                <p><strong>Isi:</strong> {{ $journal->isi }}</p>
                @if($journal->foto)
                    <img src="{{ asset('storage/' . $journal->foto) }}" class="w-32 h-32 mt-2 rounded-lg">
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
