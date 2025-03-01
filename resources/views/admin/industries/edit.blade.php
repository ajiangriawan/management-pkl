@extends('layouts.app')

@section('title', 'Edit Tempat PKL')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <h3 class="text-center text-2xl font-bold text-blue-600 mb-6">Edit Tempat PKL</h3>

        <form action="{{ route('admin.industries.update', $industry->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-gray-700 font-semibold mb-1">Nama Tempat PKL</label>
                    <input type="text" id="nama" name="nama" value="{{ $industry->nama }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label for="telepon" class="block text-gray-700 font-semibold mb-1">Telepon</label>
                    <input type="text" id="telepon" name="telepon" value="{{ $industry->telepon }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label for="latitude" class="block text-gray-700 font-semibold mb-1">Latitude</label>
                    <div class="relative">
                        <input type="text" id="latitude" name="latitude" value="{{ $industry->latitude }}"
                            class="w-full border border-gray-300 rounded-lg p-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <button type="button" onclick="showInstruction()" class="absolute inset-y-0 right-3 flex items-center text-blue-500">
                            <i data-lucide="help-circle"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="longitude" class="block text-gray-700 font-semibold mb-1">Longitude</label>
                    <div class="relative">
                        <input type="text" id="longitude" name="longitude" value="{{ $industry->longitude }}"
                            class="w-full border border-gray-300 rounded-lg p-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <button type="button" onclick="showInstruction()" class="absolute inset-y-0 right-3 flex items-center text-blue-500">
                            <i data-lucide="help-circle"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="radius" class="block text-gray-700 font-semibold mb-1">Radius Absensi (meter)</label>
                    <input type="number" id="radius" name="radius" value="{{ $industry->radius }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="md:col-span-2">
                    <label for="alamat" class="block text-gray-700 font-semibold mb-1">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ $industry->alamat }}</textarea>
                </div>

                <div class="flex justify-between mt-6">
                    <a href="{{ route('admin.industries') }}"
                        class="px-6 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
                        Perbarui
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function showInstruction() {
        alert("Cara mendapatkan Latitude & Longitude:\n\n1. Buka Google Maps\n2. Klik kanan pada lokasi yang diinginkan\n3. Pilih 'Apa di sini?'\n4. Salin koordinat yang muncul di bagian bawah layar");
    }

    lucide.createIcons();
</script>

<script src="https://unpkg.com/lucide@latest"></script>

@endsection