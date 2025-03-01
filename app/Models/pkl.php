<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'praktik_kerja_lapangans'; // Nama tabel di database

    protected $fillable = [
        'siswa_id',
        'industri_id',
        'guru_id',
        'industri_pembimbing_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    // Relasi ke model Student (Siswa)
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    // Relasi ke model Industry (Industri)
    public function industri()
    {
        return $this->belongsTo(Industry::class, 'industri_id');
    }

    // Relasi ke model Teacher (Guru Pembimbing)
    public function guru()
    {
        return $this->belongsTo(Teacher::class, 'guru_id');
    }

    // Relasi ke model IndustryMentor (Pembimbing Industri)
    public function industriPembimbing()
    {
        return $this->belongsTo(IndustryMentor::class, 'industri_pembimbing_id');
    }
}
