@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <!-- Kartu Statistik -->
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i data-lucide="users" class="text-blue-600 w-10 h-10"></i>
        <div>
            <h2 class="text-lg font-semibold">Total Guru</h2>
            <p class="text-2xl font-bold">150</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i data-lucide="building" class="text-green-600 w-10 h-10"></i>
        <div>
            <h2 class="text-lg font-semibold">Total Industri</h2>
            <p class="text-2xl font-bold">30</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i data-lucide="briefcase" class="text-yellow-600 w-10 h-10"></i>
        <div>
            <h2 class="text-lg font-semibold">Total PKL</h2>
            <p class="text-2xl font-bold">200</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
        <i data-lucide="graduation-cap" class="text-purple-600 w-10 h-10"></i>
        <div>
            <h2 class="text-lg font-semibold">Total Siswa</h2>
            <p class="text-2xl font-bold">500</p>
        </div>
    </div>
</div>

<!-- Tabel Data 
<div class="bg-white p-6 mt-6 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-4">Data Guru</h2>
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border p-3">Nama</th>
                <th class="border p-3">Email</th>
                <th class="border p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-3">John Doe</td>
                <td class="border p-3">john@example.com</td>
                <td class="border p-3 flex gap-2">
                    <a href="#" class="text-blue-500 flex items-center gap-1"><i data-lucide="edit"></i> Edit</a>
                    <a href="#" class="text-red-500 flex items-center gap-1"><i data-lucide="trash-2"></i> Hapus</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
-->
<script>
    lucide.createIcons();
</script>
@endsection
