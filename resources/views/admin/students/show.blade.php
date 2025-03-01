<!-- resources/views/admin/students/show.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Detail Siswa</h1>
<p>Nama: {{ $student->nama }}</p>
<p>Email: {{ $student->email }}</p>
<p>Telepon: {{ $student->telepon }}</p>
<p>Alamat: {{ $student->alamat }}</p>
<a href="{{ route('admin.students.edit', $student) }}">Edit</a>
<form action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
<a href="{{ route('admin.students') }}">Kembali ke Daftar Siswa</a>
@endsection