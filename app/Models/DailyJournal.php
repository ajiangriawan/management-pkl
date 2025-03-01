<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyJurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'pkl_id',
        'siswa_id',
        'tanggal',
        'isi',
        'foto',
    ];

    public function pkl()
    {
        return $this->belongsTo(pkl::class, 'pkl_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_id');
    }
}