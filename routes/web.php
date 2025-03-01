<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PKLController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman utama ke dashboard
Route::redirect('/', '/dashboard');

// Dashboard untuk semua user (admin/guru/siswa)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute profil pengguna (dapat diakses oleh semua user)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // Pastikan ini ada
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rute untuk Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rute Humas
    Route::prefix('humas')->group(function () {
        Route::get('/', [AdminController::class, 'humass'])->name('admin.humass');
        Route::get('/create', [AdminController::class, 'createHumas'])->name('admin.humass.create');
        Route::post('/', [AdminController::class, 'storeHumas'])->name('admin.humass.store');
        Route::get('/{humas}', [AdminController::class, 'showHumas'])->name('admin.humass.show');
        Route::get('/{humas}/edit', [AdminController::class, 'editHumas'])->name('admin.humass.edit');
        Route::put('/{humas}', [AdminController::class, 'updateHumas'])->name('admin.humass.update');
        Route::delete('/{humas}', [AdminController::class, 'destroyHumas'])->name('admin.humass.destroy');
    });

    // Rute Guru
    Route::prefix('teachers')->group(function () {
        Route::get('/', [AdminController::class, 'teachers'])->name('admin.teachers');
        Route::get('/create', [AdminController::class, 'createTeacher'])->name('admin.teachers.create');
        Route::post('/', [AdminController::class, 'storeTeacher'])->name('admin.teachers.store');
        Route::get('/{teacher}', [AdminController::class, 'showTeacher'])->name('admin.teachers.show');
        Route::get('/{teacher}/edit', [AdminController::class, 'editTeacher'])->name('admin.teachers.edit');
        Route::put('/{teacher}', [AdminController::class, 'updateTeacher'])->name('admin.teachers.update');
        Route::delete('/{teacher}', [AdminController::class, 'destroyTeacher'])->name('admin.teachers.destroy');
    });

    // Rute Siswa dikelola oleh Admin
    Route::prefix('students')->group(function () {
        Route::get('/', [AdminController::class, 'students'])->name('admin.students');
        Route::get('/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
        Route::post('/', [AdminController::class, 'storeStudent'])->name('admin.students.store');
        Route::get('/{student}', [AdminController::class, 'show'])->name('admin.students.show');
        Route::get('/{student}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
        Route::put('/{student}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
        Route::delete('/{student}', [AdminController::class, 'destroyStudent'])->name('admin.students.destroy');
    });

    // Rute Guru
    Route::prefix('mentors')->group(function () {
        Route::get('/', [AdminController::class, 'mentors'])->name('admin.mentors');
        Route::get('/create', [AdminController::class, 'createMentor'])->name('admin.mentors.create');
        Route::post('/', [AdminController::class, 'storeMentor'])->name('admin.mentors.store');
        Route::get('/{mentor}', [AdminController::class, 'showMentor'])->name('admin.mentors.show');
        Route::get('/{mentor}/edit', [AdminController::class, 'editMentor'])->name('admin.mentors.edit');
        Route::put('/{mentor}', [AdminController::class, 'updateMentor'])->name('admin.mentors.update');
        Route::delete('/{mentor}', [AdminController::class, 'destroyMentor'])->name('admin.mentors.destroy');
    });

    // Rute Industri
    Route::prefix('industries')->group(function () {
        Route::get('/', [AdminController::class, 'industries'])->name('admin.industries');
        Route::get('/create', [AdminController::class, 'createIndustry'])->name('admin.industries.create');
        Route::post('/', [AdminController::class, 'storeIndustry'])->name('admin.industries.store');
        Route::get('/{industry}', [AdminController::class, 'showIndustry'])->name('admin.industries.show');
        Route::get('/{industry}/edit', [AdminController::class, 'editIndustry'])->name('admin.industries.edit');
        Route::put('/{industry}', [AdminController::class, 'updateIndustry'])->name('admin.industries.update');
        Route::delete('/{industry}', [AdminController::class, 'destroyIndustry'])->name('admin.industries.destroy');
    });

    Route::get('/get-industry-mentor/{industri_id}', [PKLController::class, 'getIndustryMentor']);

    // Rute PKL
    Route::prefix('pkls')->group(function () {
        Route::get('/', [AdminController::class, 'pkls'])->name('admin.pkls');
        Route::get('/create', [AdminController::class, 'createPKL'])->name('admin.pkls.create');
        Route::post('/', [AdminController::class, 'storePKL'])->name('admin.pkls.store');
        Route::get('/{pkl}', [AdminController::class, 'showPKL'])->name('admin.pkls.show');
        Route::get('/{pkl}/edit', [AdminController::class, 'editPKL'])->name('admin.pkls.edit');
        Route::put('/{pkl}', [AdminController::class, 'updatePKL'])->name('admin.pkls.update');
        Route::delete('/{pkl}', [AdminController::class, 'destroyPKL'])->name('admin.pkls.destroy');
    });
});
// Memuat rute autentikasi Laravel
require __DIR__ . '/auth.php';
