@extends('layouts.app')

@section('title', 'Daftar Tempat PKL')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Tempat PKL</h2>
        <a href="{{ route('admin.industries.create') }}" onclick="toggleModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Tempat PKL
        </a>
    </div>
    <div class="mb-4">
        <input type="text" id="search" class="w-full px-4 py-2 border rounded focus:outline-none" placeholder="Cari Tempat PKL...">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Telepon</th>
                    <th class="px-4 py-2">Radius (m)</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($industries as $industry)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $industry->nama }}</td>
                    <td class="px-4 py-2">{{ $industry->alamat }}</td>
                    <td class="px-4 py-2">{{ $industry->telepon }}</td>
                    <td class="px-4 py-2">{{ $industry->radius }} m</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.industries.edit', $industry->id) }}" class="text-blue-500 hover:text-blue-700">
                            <i data-lucide="edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.industries.destroy', $industry->id) }}" onsubmit="return confirm('Hapus tempat PKL ini?');">
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
            let name = row.cells[1].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? "" : "none";
        });
    });

    lucide.createIcons();
</script>
@endsection