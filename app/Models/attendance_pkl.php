<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendancePkl extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'pkl_id',
        'tanggal',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }

    public function pkl()
    {
        return $this->belongsTo(pkl::class, 'pkl_id');
    }
}