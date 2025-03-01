<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $user = Auth::user();

        if ($user->role == 'Siswa') {
            $profile = $user->student;
        } elseif ($user->role === 'Admin') {
            $profile = $user->admin;
        } elseif ($user->role === 'Guru') {
            $profile = $user->guru;
        } elseif ($user->role === 'Industri') {
            $profile = $user->industri;
        } else {
            $profile = null;
        }

        return view('profile.profile', compact('user', 'profile'));
    }


    public function edit(Request $request): View
    {
        $user = Auth::user();

        if ($user->role == 'Siswa') {
            $profile = $user->student;
        } elseif ($user->role === 'Admin') {
            $profile = $user->admin;
        } elseif ($user->role === 'Guru') {
            $profile = $user->guru;
        } elseif ($user->role === 'Industri') {
            $profile = $user->industri;
        } else {
            $profile = null;
        }

        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Validasi data umum
        $validatedData = $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Hash password jika diinput
        if ($request->filled('password')) {
            $validatedData['password'] = $request->password;
        } else {
            unset($validatedData['password']); // Jangan update jika kosong
        }

        // Mulai transaksi database agar aman
        DB::transaction(function () use ($user, $validatedData, $request) {
            // Update tabel `users`
                       // Update data berdasarkan role
            switch ($user->role) {
                case 'Guru':
                    $user->teacher()->update([
                        'nama'    => $request->nama,
                        'nip'     => $request->nip,
                        'telepon' => $request->telepon,
                        'alamat'  => $request->alamat,
                    ]);
                    break;

                case 'Siswa':
                    $user->student()->update([
                        'nama'         => $request->nama,
                        'nis'          => $request->nis,
                        'kelas'        => $request->kelas,
                        'telepon'      => $request->telepon,
                        'alamat'       => $request->alamat,
                        'jurusan'      => $request->jurusan,
                    ]);
                    break;

                case 'Industri':
                    $user->industryMentor()->update([
                        'nama'     => $request->nama,
                        'telepon'  => $request->telepon,
                        'alamat'   => $request->alamat,
                        'perusahaan' => $request->perusahaan,
                    ]);
                    break;

                case 'Admin':
                    $user->admin()->update([
                        'nip'    => $request->nip,
                        'email'    => $request->email,
                        'nama'     => $request->nama,
                        'telepon'  => $request->telepon,
                        'alamat'   => $request->alamat,
                    ]);
                    break;
            }

             $user->update($validatedData);
        });

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
