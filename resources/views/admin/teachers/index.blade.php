@extends('layouts.app')

@section('title', 'Daftar Guru Pembimbing')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Guru Pembimbing</h2>
        <a href="{{ route('admin.teachers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Tambah Data
        </a>
    </div>

    <div class="mb-4">
        <input type="text" id="search" class="w-full px-4 py-2 border rounded focus:outline-none" placeholder="Cari Guru Pembimbing...">
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
            <tbody id="teacher-table">
                @foreach ($teachers as $teacher)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $teacher->nip }}</td>
                    <td class="px-4 py-2">{{ $teacher->nama }}</td>
                    <td class="px-4 py-2">{{ $teacher->telepon }}</td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="text-blue-500 hover:text-blue-700">
                            <i data-lucide="edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
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
        let rows = document.querySelectorAll("#teacher-table tr");

        rows.forEach(row => {
            let name = row.cells[2].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? "" : "none";
        });
    });

    lucide.createIcons();
</script>
@endsection