<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
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


    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
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

        // Gunakan transaction agar jika satu update gagal, perubahan tidak terjadi
        DB::transaction(function () use ($student, $validatedData) {
            // Bandingkan data lama dan data baru untuk Student
            $filteredStudentData = array_filter($validatedData, function ($value, $key) use ($student) {
                return $student->$key != $value;
            }, ARRAY_FILTER_USE_BOTH);

            // Jika ada perubahan, update data student
            if (!empty($filteredStudentData)) {
                $student->update($filteredStudentData);
            }

            // Cek apakah user terkait ada
            if ($student->user) {
                $filteredUserData = [
                    'name' => $validatedData['nama'],
                    'email' => $validatedData['email'],
                ];

                // Jika email berubah, update user juga
                if ($student->user->email !== $validatedData['email']) {
                    $student->user->update($filteredUserData);
                }
            }
        });

        return redirect()->route('admin.students')->with('success', 'Data siswa dan user berhasil diperbarui.');
    }



    public function destroy(Student $student)
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
}
