@extends('layouts.app')

@section('title', 'Daftar Absensi Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Daftar Absensi Siswa</h3>
        <div>
            <a href="{{ route('siswa.attendance.masuk') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Absen Masuk</a>
            <a href="{{ route('siswa.attendance.pulang') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Absen Pulang</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto rounded-lg border shadow-md">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Nama Siswa</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Waktu</th>
                    <th class="px-4 py-2">Lokasi</th>
                    <th class="px-4 py-2">Tipe</th>
                    <th class="px-4 py-2">Foto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $index => $attendance)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $attendance->siswa->nama}}</td>
                    <td class="px-4 py-2">{{ $attendance->tanggal }}</td>
                    <td class="px-4 py-2">{{ $attendance->waktu }}</td>
                    <td class="px-4 py-2">{{ $attendance->latitude }}, {{ $attendance->longitude }}</td>
                    <td class="px-4 py-2">
                        <span class="badge {{ $attendance->jenis_absensi == 'Masuk' ? 'badge-success' : 'badge-danger' }}">
                            {{ $attendance->jenis_absensi }}
                        </span>
                    </td>
                    <td>
                        <img src="{{ asset('storage/' . $attendance->selfie) }}" alt="Selfie" width="80">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection