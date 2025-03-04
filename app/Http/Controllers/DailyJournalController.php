<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyJournal;
use App\Models\PKL;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DailyJournalController extends Controller
{
    /**
     * Menampilkan daftar jurnal berdasarkan user yang login.
     */
    public function index()
    {
        $user = Auth::user();
        $journals = DailyJournal::whereHas('pkl', function ($query) use ($user) {
            $query->whereHas('siswa', function ($q) use ($user) {
                $q->where('email', $user->email);
            });
        })->latest()->get();

        return view('siswa.journal.index', compact('journals'));
    }

    /**
     * Menampilkan form untuk membuat jurnal baru.
     */
    public function create()
    {
        return view('siswa.journal.create');
    }

    /**
     * Menyimpan jurnal baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $data = [
            'pkl_id' => $pkl->id,
            'tanggal' => now(),
            'isi' => $request->isi,
        ];

        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('jurnal_foto', 'public');
            $data['foto'] = $filePath;
        }

        DailyJournal::create($data);

        return redirect()->route('siswa.journal.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    /**
     * Menampilkan detail jurnal tertentu.
     */
    public function show($id)
    {
        $journal = DailyJournal::findOrFail($id);
        return view('siswa.journal.show', compact('journal'));
    }

    /**
     * Menampilkan form edit jurnal.
     */
    public function edit($id)
    {
        $journal = DailyJournal::findOrFail($id);
        return view('siswa.journal.edit', compact('journal'));
    }

    /**
     * Memperbarui jurnal yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $journal = DailyJournal::findOrFail($id);

        $journal->isi = $request->isi;

        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('jurnal_foto', 'public');
            $journal->foto = $filePath;
        }

        $journal->save();

        return redirect()->route('siswa.journal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    /**
     * Menghapus jurnal dari database.
     */
    public function destroy($id)
    {
        $journal = DailyJournal::findOrFail($id);
        $journal->delete();

        return redirect()->route('siswa.journal.index')->with('success', 'Jurnal berhasil dihapus.');
    }

    /**
     * Cek apakah jurnal sudah diisi sebelum absen pulang.
     */
    public function checkJournal()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $journalExists = DailyJournal::whereHas('pkl', function ($query) use ($user) {
            $query->whereHas('student', function ($q) use ($user) {
                $q->where('email', $user->email);
            });
        })->whereDate('tanggal', $today)->exists();

        return response()->json(['journalExists' => $journalExists]);
    }
}
