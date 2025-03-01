@extends('layouts.app')

@section('title', 'Daftar Admin Humas')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Admin Humas</h2>
        <a href="{{ route('admin.humass.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Data
        </a>
    </div>

    <div class="mb-4">
        <input type="text" id="search" class="w-full px-4 py-2 border rounded focus:outline-none" placeholder="Cari Admin Humas...">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">NIP</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">No Telepon</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="humas-table">
                @foreach ($humass as $humas)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $humas->nip }}</td>
                    <td class="px-4 py-2">{{ $humas->nama }}</td>
                    <td class="px-4 py-2">{{ $humas->telepon }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.humass.edit', $humas->id) }}" class="text-blue-500 hover:text-blue-700">
                            <i data-lucide="edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.humass.destroy', $humas->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
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

<script>
    document.getElementById("search").addEventListener("input", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#humas-table tr");

        rows.forEach(row => {
            let name = row.cells[2].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? "" : "none";
        });
    });

    lucide.createIcons();
</script>
@endsection