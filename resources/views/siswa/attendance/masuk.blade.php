@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Absensi PKL</h1>

    <!-- Lokasi GPS -->
    <div class="mb-4 p-4 border rounded-lg bg-gray-100">
        <p><strong>Lokasi Saat Ini:</strong> <span id="current-location">Mengambil lokasi...</span></p>
    </div>

    <!-- Preview Foto -->
    <div class="mb-4 text-center">
        <video id="video" class="w-48 h-48 mx-auto border rounded-lg" autoplay></video>
        <canvas id="canvas" class="hidden"></canvas>
        <img id="photo" class="hidden w-48 h-48 mx-auto border rounded-lg">
    </div>

    <!-- Tombol Ambil Foto -->
    <div class="flex justify-center">
        <button id="capture-btn" type="button" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Ambil Foto</button>
    </div>

    <!-- Form Absensi -->
    <form id="attendance-form" action="{{ route('siswa.attendance.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="selfie" id="selfie-data">

        <label class="block text-gray-700 font-bold mt-4">Keterangan:</label>
        <textarea name="keterangan" class="border rounded-lg w-full p-2" required></textarea>

        <button type="submit" id="submit-btn" class="bg-green-500 text-white px-6 py-2 rounded-lg mt-4 w-full" disabled>Kirim Absensi</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let industryLatitude = parseFloat("{{ $industry->latitude }}");
        let industryLongitude = parseFloat("{{ $industry->longitude }}");
        let allowedRadius = parseFloat("{{ $industry->radius }}");
        let isLocationValid = false;
        let isPhotoTaken = false;

        function getDistance(lat1, lon1, lat2, lon2) {
            let R = 6371e3;
            let φ1 = lat1 * Math.PI / 180;
            let φ2 = lat2 * Math.PI / 180;
            let Δφ = (lat2 - lat1) * Math.PI / 180;
            let Δλ = (lon2 - lon1) * Math.PI / 180;
            let a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function enableSubmit() {
            document.getElementById("submit-btn").disabled = !(isLocationValid && isPhotoTaken);
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let userLat = position.coords.latitude;
                    let userLon = position.coords.longitude;
                    document.getElementById("latitude").value = userLat;
                    document.getElementById("longitude").value = userLon;
                    document.getElementById("current-location").textContent = `${userLat}, ${userLon}`;

                    let distance = getDistance(userLat, userLon, industryLatitude, industryLongitude);
                    if (distance <= allowedRadius) {
                        isLocationValid = true;
                        enableSubmit();
                    } else {
                        alert("Anda berada di luar area absensi!");
                    }
                },
                function(error) {
                    document.getElementById("current-location").textContent = "Gagal mengambil lokasi";
                }
            );
        } else {
            document.getElementById("current-location").textContent = "Geolocation tidak didukung";
        }

        let video = document.getElementById("video");
        let canvas = document.getElementById("canvas");
        let photo = document.getElementById("photo");
        let captureBtn = document.getElementById("capture-btn");

        navigator.mediaDevices.getUserMedia({
            video: true
        }).then(function(stream) {
            video.srcObject = stream;
        }).catch(function(error) {
            alert("Gagal mengakses kamera: " + error.message);
        });

        captureBtn.addEventListener("click", function() {
            let context = canvas.getContext("2d");
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            let imageData = canvas.toDataURL("image/png");
            document.getElementById("selfie-data").value = imageData;

            video.classList.add("hidden");
            photo.src = imageData;
            photo.classList.remove("hidden");

            isPhotoTaken = true;
            enableSubmit();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        let submitBtn = document.getElementById("submit-btn");

        fetch("{{ route('siswa.journal.check') }}")
            .then(response => response.json())
            .then(data => {
                if (!data.journalExists) {
                    submitBtn.disabled = true;
                    alert("Anda harus mengisi jurnal harian sebelum absen pulang!");
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
@endsection