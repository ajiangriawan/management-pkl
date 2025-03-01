<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'telepon',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'penilai_id');
    }
}
