<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances'; // Pastikan tabel sesuai dengan migration

    protected $fillable = [
        'siswa_id',
        'pkl_id',
        'tanggal',
        'waktu',
        'latitude',
        'longitude',
        'selfie',
        'jenis_absensi',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    // Relasi ke PKL
    public function pkl()
    {
        return $this->belongsTo(PKL::class, 'pkl_id');
    }
}
