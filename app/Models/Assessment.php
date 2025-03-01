<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pkl_id',
        'penilai_id',
        'jenis_penilai',
        'nilai',
        'keterangan',
    ];

    public function pkl()
    {
        return $this->belongsTo(pkl::class, 'pkl_id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }
}