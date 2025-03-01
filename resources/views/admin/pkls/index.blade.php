@extends('layouts.app')

@section('title', 'Data PKL')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Data PKL</h3>
        <a href="{{ route('admin.pkls.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah PKL</a>
    </div>

    <div class="mb-4">
        <input type="text" id="search" class="w-full px-4 py-2 border rounded focus:outline-none" placeholder="Cari Pembimbing Industri...">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto rounded-lg border shadow-md">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Siswa</th>
                    <th class="px-4 py-2">Industri</th>
                    <th class="px-4 py-2">Guru</th>
                    <th class="px-4 py-2">Pembimbing Industri</th>
                    <!--<th class="px-4 py-2">Tanggal Mulai</th>
                <th class="px-4 py-2">Tanggal Selesai</th>-->
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pkls as $pkl)
                <tr>
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $pkl->siswa->nama }}</td>
                    <td class="px-4 py-2">{{ $pkl->industri->nama }}</td>
                    <td class="px-4 py-2">{{ $pkl->guru->nama }}</td>
                    <td class="px-4 py-2">{{ $pkl->industriPembimbing->nama }}</td>
                    <!--<td class="px-4 py-2">{{ $pkl->tanggal_mulai }}</td>
                <td class="px-4 py-2">{{ $pkl->tanggal_selesai }}</td>-->
                    <td class="px-4 py-2">{{ $pkl->status }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.pkls.edit', $pkl->id) }}" class="text-blue-500 hover:text-blue-700">
                            <i data-lucide="edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.pkls.destroy', $pkl->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i data-lucide="trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection