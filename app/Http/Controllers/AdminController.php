<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Industry;
use App\Models\IndustryMentor;
use App\Models\PKL;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Menampilkan dashboard admin
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $totalTeachers = Teacher::count();
        $totalIndustries = Industry::count();
        $totalPKL = PKL::count();
        $completedPKL = PKL::where('status', 'Selesai')->count();

        return view('admin.dashboard', compact('totalStudents', 'activeStudents', 'totalTeachers', 'totalIndustries', 'totalPKL', 'completedPKL'));
    }

    // CRUD untuk Siswa
    public function students()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    // Menyimpan data siswa
    public function storeStudent(Request $request)
    {
        // Validasi data input
        Log::info('Request Data:', $request->all());

        $request->validate([
            'nisn' => 'required|numeric|unique:students,nisn',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'telepon' => 'required|string|max:15',
            'kelas' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status' => 'required|in:Active,Deactive',
        ]);

        try {
            $student = Student::create([
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'status' => $request->status,
            ]);

            $user = User::create([
                'email' => $request->email,
                'username' => strtolower(str_replace(' ', '', $request->nama)),
                'password' => 'Siswa123', // Default password
                'role' => 'Siswa',
            ]);

            Log::info('Siswa berhasil ditambahkan:', ['student' => $student, 'user' => $user]);

            return redirect()->route('admin.students')->with('success', 'Siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan siswa:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menambahkan siswa.');
        }
    }

    public function editStudent(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, Student $student)
    {
        // Validasi Data
        $validatedData = $request->validate([
            'nisn' => 'required|numeric|unique:students,nisn,' . $student->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'telepon' => 'required|numeric',
            'kelas' => 'required|string',
            'status' => 'required|in:Active,Deactive',
            'alamat' => 'required|string',
        ]);

        // Gunakan Transaction agar jika ada error, perubahan dibatalkan
        DB::transaction(function () use ($student, $validatedData) {
            // Simpan email lama sebelum update
            $oldEmail = $student->email;

            // Update data Student
            $student->update($validatedData);

            // Cek apakah ada User dengan email lama
            $user = User::where('email', $oldEmail)->first();

            if ($user) {
                // Update data user dengan email baru (jika berubah)
                $user->update([
                    'name' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                ]);
            }
        });

        return redirect()->route('admin.students')->with('success', 'Data siswa dan user berhasil diperbarui.');
    }

    public function destroyStudent(Student $student)
    {
        try {
            $user = User::where('email', $student->email)->first();

            if ($user) {
                $user->delete();
            }

            $student->delete();
            return redirect()->route('admin.students')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.students')->with('error', 'Gagal menghapus siswa.');
        }
    }

    // CRUD untuk Guru
    public function teachers()
    {
        $teachers = Teacher::all();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function createTeacher()
    {
        return view('admin.teachers.create');
    }

    public function storeTeacher(Request $request)
    {

        // Validasi data input
        Log::info('Request Data:', $request->all());

        $request->validate([
            'nip' => 'required|numeric|unique:teachers,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        try {
            $teacher = Teacher::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            $user = User::create([
                'email' => $request->email,
                'username' => strtolower(str_replace(' ', '', $request->nama)),
                'password' => 'Guru123', // Default password
                'role' => 'Guru',
            ]);

            Log::info('Guru Pembimbing berhasil ditambahkan:', ['teacher' => $teacher, 'user' => $user]);

            return redirect()->route('admin.teachers')->with('success', 'Guru Pembimbing berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan Guru Pembimbing:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menambahkan Guru Pembimbing.');
        }
    }

    public function editTeacher(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function updateTeacher(Request $request, Teacher $teacher)
    {
        // Validasi Data
        $validatedData = $request->validate([
            'nip' => 'required|numeric|unique:teachers,nip,' . $teacher->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ]);

        // Gunakan Transaction agar jika ada error, perubahan dibatalkan
        DB::transaction(function () use ($teacher, $validatedData) {
            // Simpan email lama sebelum update
            $oldEmail = $teacher->email;

            // Update data Teacher
            $teacher->update($validatedData);

            // Cek apakah ada User dengan email lama
            $user = User::where('email', $oldEmail)->first();

            if ($user) {
                // Update data user dengan email baru (jika berubah)
                $user->update([
                    'name' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                ]);
            }
        });

        return redirect()->route('admin.teachers')->with('success', 'Data Guru Pembimbing dan user berhasil diperbarui.');
    }

    public function destroyTeacher(Teacher $teacher)
    {
        try {
            $user = User::where('email', $teacher->email)->first();

            if ($user) {
                $user->delete();
            }

            $teacher->delete();
            return redirect()->route('admin.teachers')->with('success', 'Guru Pembimbing berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.teachers')->with('error', 'Gagal menghapus Guru Pembimbing.');
        }
    }

    // CRUD untuk Admins (HUMAS)
    public function humass()
    {
        $humass = Admin::all();
        return view('admin.humass.index', compact('humass'));
    }

    public function createHumas()
    {
        return view('admin.humass.create');
    }

    public function storeHumas(Request $request)
    {
        // Validasi data input
        Log::info('Request Data:', $request->all());

        $request->validate([
            'nip' => 'required|numeric|unique:humass,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:humass,email',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        try {
            $humas = Admin::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            $user = User::create([
                'email' => $request->email,
                'username' => strtolower(str_replace(' ', '', $request->nama)),
                'password' => 'Admin123', // Default password
                'role' => 'Admin',
            ]);

            Log::info('Admin berhasil ditambahkan:', ['humas' => $humas, 'user' => $user]);

            return redirect()->route('admin.humass')->with('success', 'Admin berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan Admin:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menambahkan Admin.');
        }
    }

    public function editHumas(Admin $humas)
    {
        return view('admin.humass.edit', compact('humas'));
    }

    public function updateHumas(Request $request, Admin $humas)
    {
        // Validasi Data
        $validatedData = $request->validate([
            'nip' => 'required|numeric|unique:admins,nip,' . $humas->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $humas->id,
            'telepon' => 'required|numeric',
            'alamat' => 'required|string',
        ]);

        // Gunakan Transaction agar jika ada error, perubahan dibatalkan
        DB::transaction(function () use ($humas, $validatedData) {
            // Simpan email lama sebelum update
            $oldEmail = $humas->email;

            // Update data Admin Humas
            $humas->update($validatedData);

            // Cek apakah ada User dengan email lama
            $user = User::where('email', $oldEmail)->first();

            if ($user) {
                // Update data user dengan email baru (jika berubah)
                $user->update([
                    'name' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                ]);
            }
        });

        return redirect()->route('admin.humass')->with('success', 'Data Admin dan user berhasil diperbarui.');
    }

    public function destroyHumas(Admin $humas)
    {
        try {
            $user = User::where('email', $humas->email)->first();

            if ($user) {
                $user->delete();
            }

            $humas->delete();
            return redirect()->route('admin.humass')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.humass')->with('error', 'Gagal menghapus Admin.');
        }
    }

    // CRUD untuk Mentor Pembimbing Industri
    public function mentors()
    {
        $industries = Industry::all();
        $mentors = IndustryMentor::all();
        return view('admin.mentors.index', compact('mentors', 'industries'));
    }

    public function createMentor()
    {
        $industries = Industry::all();
        return view('admin.mentors.create', compact('industries'));
    }

    public function storeMentor(Request $request)
    {
        // Validasi data input
        Log::info('Request Data:', $request->all());

        $request->validate([
            'industri_id' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:industry_mentors,email',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        try {
            $mentor = IndustryMentor::create([
                'industri_id' => $request->industri_id,
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            $user = User::create([
                'email' => $request->email,
                'username' => strtolower(str_replace(' ', '', $request->nama)),
                'password' => 'Mentor123', // Default password
                'role' => 'Mentor',
            ]);

            Log::info('Pembimbing Industri berhasil ditambahkan:', ['mentor' => $mentor, 'user' => $user]);

            return redirect()->route('admin.mentors')->with('success', 'Pembimbing Industri berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan Pembimbing Industri:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menambahkan Pembimbing Industri.');
        }
    }

    public function editMentor(IndustryMentor $mentor)
    {
        $industries = Industry::all(); // Mengambil semua data industri
        return view('admin.mentors.edit', compact('mentor', 'industries'));
    }

    public function updateMentor(Request $request, IndustryMentor $mentor)
    {
        // Validasi Data
        $validatedData = $request->validate([
            'industri_id' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:industry_mentors,email,' . $mentor->id,
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($mentor, $validatedData) {
                // Simpan email lama sebelum update
                $oldEmail = $mentor->email;

                // Update data mentor
                $mentor->update([
                    'industri_id' => $validatedData['industri_id'],
                    'nama' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                    'telepon' => $validatedData['telepon'],
                    'alamat' => $validatedData['alamat'],
                ]);

                // Update user jika email berubah
                $user = User::where('email', $oldEmail)->first();
                if ($user) {
                    $user->update([
                        'name' => $validatedData['nama'],
                        'email' => $validatedData['email'],
                    ]);
                }
            });

            return redirect()->route('admin.mentors')->with('success', 'Data Pembimbing Industri berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui mentor:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal memperbarui Pembimbing Industri.');
        }
    }


    public function destroyMentor(IndustryMentor $mentor)
    {
        try {
            $user = User::where('email', $mentor->email)->first();

            if ($user) {
                $user->delete();
            }

            $mentor->delete();
            return redirect()->route('admin.mentors')->with('success', 'Pembimbing Industri berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.mentors')->with('error', 'Gagal menghapus Pembimbing Industri.');
        }
    }

    // CRUD untuk Industri
    public function industries()
    {
        $industries = Industry::all();
        return view('admin.industries.index', compact('industries'));
    }

    public function createIndustry()
    {
        return view('admin.industries.create');
    }

    public function storeIndustry(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'telepon'   => 'required|string|max:15',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius'    => 'required|integer|min:10',
        ]);

        Industry::create($request->all());

        return redirect()->route('admin.industries')->with('success', 'Tempat PKL berhasil ditambahkan!');
    }

    public function editIndustry($id)
    {
        $industry = Industry::findOrFail($id);
        return view('admin.industries.edit', compact('industry'));
    }

    public function updateIndustry(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:1',
            'alamat' => 'required|string',
        ]);

        $industry = Industry::findOrFail($id);
        $industry->update($request->all());

        return redirect()->route('admin.industries')->with('success', 'Tempat PKL berhasil diperbarui!');
    }


    public function destroyIndustry($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->delete();

        return redirect()->route('admin.industries')->with('success', 'Tempat PKL berhasil dihapus!');
    }

    // CRUD untuk PKL
    public function pkls()
    {
        $pkls = PKL::with(['siswa', 'industri', 'guru', 'industriPembimbing'])->get();
        return view('admin.pkls.index', compact('pkls'));
    }

    public function createPKL()
    {
        $students = Student::all();
        $industries = Industry::all();
        $teachers = Teacher::all();
        $mentors = IndustryMentor::all();
        return view('admin.pkls.create', compact('students', 'industries', 'teachers', 'mentors'));
    }

    public function getIndustryMentor($industri_id)
    {
        $mentor = DB::table('industry_mentors')->where('industri_id', $industri_id)->first();
        return response()->json($mentor);
    }

    public function storePKL(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'industri_id' => 'required',
            'guru_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:Dalam Proses,Selesai',
        ]);

        // Ambil industri_pembimbing_id secara otomatis jika belum diisi
        if (!$request->industri_pembimbing_id) {
            $mentor = DB::table('industry_mentors')->where('industri_id', $request->industri_id)->first();
            $request->merge(['industri_pembimbing_id' => $mentor ? $mentor->id : null]);
        }

        if (!$request->industri_pembimbing_id) {
            return back()->withErrors(['industri_pembimbing_id' => 'Pembimbing industri tidak ditemukan!']);
        }

        PKL::create($request->all());

        return redirect()->route('admin.pkls')->with('success', 'PKL berhasil ditambahkan!');
    }


    public function editPKL(PKL $pkl)
    {
        $students = Student::all();
        $industries = Industry::all();
        $teachers = Teacher::all();
        $mentors = IndustryMentor::all(); // Memastikan mentor tersedia

        return view('admin.pkls.edit', compact('pkl', 'students', 'industries', 'teachers', 'mentors'));
    }

    public function updatePKL(Request $request, PKL $pkl)
    {
        // Validasi input tanpa industri_pembimbing_id
        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:students,id',
            'industri_id' => 'required|exists:industries,id',
            'guru_id' => 'required|exists:teachers,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Dalam Proses,Selesai',
        ]);

        // Cari pembimbing industri berdasarkan industri yang dipilih
        $mentor = IndustryMentor::where('industri_id', $request->industri_id)->first();

        // Update data PKL dengan pembimbing industri otomatis
        $pkl->update(array_merge($validatedData, [
            'industri_pembimbing_id' => $mentor ? $mentor->id : null
        ]));

        return redirect()->route('admin.pkls')->with('success', 'Data PKL berhasil diperbarui.');
    }
}
