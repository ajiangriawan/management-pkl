<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Industry;
use App\Models\Student;
use App\Models\PKL;
use App\Models\DailyJournal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar absensi siswa
     */

    public function index()
    {
        // Ambil email user yang sedang login
        $userEmail = Auth::user()->email;

        // Cari siswa yang memiliki email yang sama
        $student = Student::where('email', $userEmail)->first();

        // Jika tidak ditemukan siswa dengan email tersebut
        if (!$student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan!');
        }

        // Ambil data absensi berdasarkan siswa yang ditemukan
        $attendances = Attendance::where('siswa_id', $student->id)->get();

        // Kirim data absensi ke tampilan
        return view('siswa.attendance.index', compact('attendances'));
    }


    public function masukAttendance()
    {
        $user = auth()->user();
        $siswa = Student::where('email', $user->email)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $pkl = PKL::where('siswa_id', $siswa->id)
            ->where('status', 'Dalam Proses')
            ->first();

        if (!$pkl) {
            return redirect()->back()->with('error', 'Anda tidak memiliki PKL yang aktif.');
        }

        $industry = Industry::find($pkl->industri_id);

        return view('siswa.attendance.masuk', compact('industry'));
    }

    /**
     * Menyimpan absensi masuk
     */

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'selfie' => 'required',
            'keterangan' => 'nullable'
        ]);

        // Ambil data siswa berdasarkan email user yang sedang login
        $user = auth()->user();
        $siswa = Student::where('email', $user->email)->first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cari data PKL berdasarkan siswa_id dari tabel students
        $pkl = PKL::where('siswa_id', $siswa->id)->first();
        if (!$pkl) {
            return back()->with('error', 'Anda tidak terdaftar dalam PKL.');
        }

        // Ambil data industri dari PKL
        $industry = Industry::find($pkl->industri_id);
        if (!$industry) {
            return back()->with('error', 'Data industri tidak ditemukan.');
        }

        // Hitung jarak antara siswa dengan industri
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $industry->latitude,
            $industry->longitude
        );

        // Cek apakah siswa berada dalam radius industri
        if ($distance > $industry->radius) {
            return back()->with('error', 'Anda berada di luar lokasi PKL. Absensi tidak dapat dilakukan.');
        }

        // **Simpan gambar selfie dengan format file**
        if ($request->has('selfie')) {
            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $request->selfie);
            $imagePath = 'selfies/' . uniqid() . '.png';

            // Simpan gambar di storage Laravel
            Storage::disk('public')->put($imagePath, base64_decode($imageData));
        }

        // **Simpan data absensi dengan waktu**
        Attendance::create([
            'pkl_id' => $pkl->id,
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(), // Simpan tanggal hari ini
            'waktu' => now()->toTimeString(),  // Simpan waktu saat ini
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'selfie' => $imagePath, // Simpan path gambar
            'jenis_absensi' => 'Masuk',
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('siswa.attendance.index')->with('success', 'Absensi berhasil dikirim!');
    }

    // Fungsi untuk menghitung jarak dengan Haversine Formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // hasil dalam meter
    }

    public function pulangAttendance(Request $request)
    {
        // Ambil data user yang sedang login
        $user = auth()->user();
        $siswa = Student::where('email', $user->email)->first();
        $pkl = PKL::where('siswa_id', $siswa->id)->first();

        // Jika tidak ditemukan siswa dengan email tersebut
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cek apakah siswa sudah absen masuk
        $absenMasuk = Attendance::where('siswa_id', $siswa->id)
            ->where('jenis_absensi', 'Masuk')
            ->whereDate('created_at', today())
            ->first();

        if (!$absenMasuk) {
            return redirect()->back()->with('error', 'Anda harus melakukan absen masuk terlebih dahulu.');
        }

        // Cek apakah siswa sudah mengisi jurnal harian
        $jurnal = DailyJournal::where('pkl_id', $pkl->id)
            ->whereDate('created_at', today())
            ->first();

        if (!$jurnal) {
            return redirect()->back()->with('error', 'Anda harus mengisi jurnal harian terlebih dahulu.');
        }

        $industry = Industry::find($pkl->industri_id);
        return view('siswa.attendance.pulang', compact('siswa', 'industry', 'pkl'));
    }

    /**
     * Menyimpan absensi pulang setelah mengisi jurnal
     */
    public function storePulang(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'selfie' => 'required',
            'keterangan' => 'nullable',
            'siswa_id' => 'required|exists:students,id',
            'pkl_id' => 'required|exists:praktik_kerja_lapangans,id',
        ]);

        // Ambil data siswa berdasarkan email user yang sedang login
        $user = auth()->user();
        $siswa = Student::where('email', $user->email)->first();

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Cari data PKL berdasarkan siswa_id dari tabel students
        $pkl = PKL::where('siswa_id', $siswa->id)->first();
        if (!$pkl) {
            return back()->with('error', 'Anda tidak terdaftar dalam PKL.');
        }

        // Ambil data industri dari PKL
        $industry = Industry::find($pkl->industri_id);
        if (!$industry) {
            return back()->with('error', 'Data industri tidak ditemukan.');
        }

        // Hitung jarak antara siswa dengan industri
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $industry->latitude,
            $industry->longitude
        );

        // Cek apakah siswa berada dalam radius industri
        if ($distance > $industry->radius) {
            return back()->with('error', 'Anda berada di luar lokasi PKL. Absensi tidak dapat dilakukan.');
        }

        // **Simpan gambar selfie dengan format file**
        if ($request->has('selfie')) {
            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $request->selfie);
            $imagePath = 'selfies/' . uniqid() . '.png';

            // Simpan gambar di storage Laravel
            Storage::disk('public')->put($imagePath, base64_decode($imageData));
        }

        // Cek apakah siswa sudah absen masuk
        $absenMasuk = Attendance::where('siswa_id', $siswa->id)
            ->where('jenis_absensi', 'Masuk')
            ->whereDate('created_at', today()) // Pastikan absen masuk hari ini
            ->first();

        if (!$absenMasuk) {
            return redirect()->back()->with('error', 'Anda harus melakukan absen masuk sebelum absen pulang.');
        }

        // Cek apakah jurnal sudah diisi
        $jurnal = DailyJournal::where('pkl_id', $pkl->id)
            ->whereDate('created_at', today()) // Pastikan jurnal hari ini
            ->first();

        if (!$jurnal) {
            return redirect()->back()->with('error', 'Anda harus mengisi jurnal harian sebelum absen pulang.');
        }

        // **Simpan gambar selfie dengan format file**
        if ($request->has('selfie')) {
            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $request->selfie);
            $imagePath = 'selfies/' . uniqid() . '.png';

            // Simpan gambar di storage Laravel
            Storage::disk('public')->put($imagePath, base64_decode($imageData));
        }

        // Simpan data absensi pulang
        Attendance::create([
            'pkl_id' => $pkl->id,
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(), // Simpan tanggal hari ini
            'waktu' => now()->toTimeString(),  // Simpan waktu saat ini
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'selfie' => $imagePath, // Simpan path gambar
            'jenis_absensi' => 'Pulang',
            'keterangan' => $request->keterangan,// Pastikan Anda juga menangkap longitude jika diperlukan
        ]);
        return redirect()->route('siswa.attendance.index')->with('success', 'Absen pulang berhasil disimpan.');

    }


    /**
     * Menampilkan detail absensi siswa
     */
    public function show($id)
    {
        $attendance = Attendance::with(['siswa', 'pkl'])->findOrFail($id);
        return response()->json($attendance);
    }

    /**
     * Menghapus data absensi
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);

        // Hapus file selfie jika ada
        if ($attendance->selfie) {
            Storage::disk('public')->delete($attendance->selfie);
        }

        $attendance->delete();
        return response()->json(['message' => 'Absensi berhasil dihapus!']);
    }

    /**
     * Cek apakah lokasi siswa sesuai dengan lokasi PKL
     */
    private function cekLokasi($latitudeSiswa, $longitudeSiswa, $latitudePKL, $longitudePKL)
    {
        $radius = 0.05; // 50 meter (ubah sesuai kebutuhan)
        $jarak = sqrt(pow($latitudeSiswa - $latitudePKL, 2) + pow($longitudeSiswa - $longitudePKL, 2));
        return $jarak <= $radius;
    }
}
