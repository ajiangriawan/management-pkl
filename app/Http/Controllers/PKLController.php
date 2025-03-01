<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Industry;
use App\Models\Teacher;
use App\Models\IndustryMentor;
use App\Models\pkl;
use Illuminate\Http\Request;

class PKLController extends Controller
{
    // Menampilkan daftar PKL
    public function index()
    {
        $pkls = pkl::with(['student', 'industry', 'teacher', 'industryMentor'])->get();
        return view('pkl.index', compact('pkls'));
    }

    // Menampilkan form tambah PKL
    public function create()
    {
        $students = Student::all();
        $industries = Industry::all();
        $teachers = Teacher::all();
        $industryMentors = IndustryMentor::all();
        return view('pkl.create', compact('students', 'industries', 'teachers', 'industryMentors'));
    }

    // Menyimpan data PKL baru
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:students,id',
            'industri_id' => 'required|exists:industries,id',
            'guru_id' => 'required|exists:teachers,id',
            'industri_pembimbing_id' => 'required|exists:industry_mentors,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:Dalam Proses,Selesai',
        ]);

        pkl::create($request->all());
        return redirect()->route('pkl.index')->with('success', 'PKL berhasil ditambahkan.');
    }

    // Menampilkan detail PKL
    public function show(pkl $pkl)
    {
        return view('pkl.show', compact('pkl'));
    }

    // Menampilkan form edit PKL
    public function edit(pkl $pkl)
    {
        $students = Student::all();
        $industries = Industry::all();
        $teachers = Teacher::all();
        $industryMentors = IndustryMentor::all();
        return view('pkl.edit', compact('pkl', 'students', 'industries', 'teachers', 'industryMentors'));
    }

    // Mengupdate data PKL
    public function update(Request $request, pkl $pkl)
    {
        $request->validate([
            'siswa_id' => 'required|exists:students,id',
            'industri_id' => 'required|exists:industries,id',
            'guru_id' => 'required|exists:teachers,id',
            'industri_pembimbing_id' => 'required|exists:industry_mentors,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:Dalam Proses,Selesai',
        ]);

        $pkl->update($request->all());
        return redirect()->route('pkl.index')->with('success', 'PKL berhasil diperbarui.');
    }

    // Menghapus data PKL
    public function destroy(pkl $pkl)
    {
        $pkl->delete();
        return redirect()->route('pkl.index')->with('success', 'PKL berhasil dihapus.');
    }
}