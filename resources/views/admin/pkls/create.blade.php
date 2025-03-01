@extends('layouts.app')

@section('title', 'Tambah PKL')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <h3 class="text-center text-2xl font-bold text-blue-600 mb-6">Tambah PKL</h3>

        <form action="{{ route('admin.pkls.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    {{-- Pilih Siswa --}}
                    <label for="siswa_id" class="text-gray-700 font-semibold mb-1">Siswa</label>
                    <select name="siswa_id" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400">
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    {{-- Pilih Industri --}}
                    <label for="industri_id" class="text-gray-700 font-semibold mb-1">Industri</label>
                    <select id="industri_id" name="industri_id" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400">
                        <option value="" disabled selected>Pilih Industri</option>
                        @foreach ($industries as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    {{-- Pilih Guru Pembimbing --}}
                    <label for="guru_id" class="text-gray-700 font-semibold mb-1">Guru Pembimbing</label>
                    <select name="guru_id" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400">
                        <option value="" disabled selected>Pilih Guru Pembimbing</option>
                        @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    {{-- Tanggal Mulai --}}
                    <label for="tanggal_mulai" class="text-gray-700 font-semibold mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    {{-- Tanggal Selesai --}}
                    <label for="tanggal_selesai" class="text-gray-700 font-semibold mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    {{-- Status --}}
                    <label for="status" class="text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-400">
                        <option value="Dalam Proses">Dalam Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>

            <div>
                {{-- Input Hidden untuk Pembimbing Industri --}}
                <input type="hidden" id="industri_pembimbing_id" name="industri_pembimbing_id">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.pkls') }}" class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- jQuery untuk AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#industri_id').change(function() {
            let industriId = $(this).val();
            if (industriId) {
                $.ajax({
                    url: '/get-industry-mentor/' + industriId,
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            $('#industri_pembimbing_id').val(response.id);
                        } else {
                            $('#industri_pembimbing_id').val('');
                        }
                    }
                });
            } else {
                $('#industri_pembimbing_id').val('');
            }
        });
    });
</script>


@endsection