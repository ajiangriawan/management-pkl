<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $fillable = ['nisn', 'nama', 'email', 'telepon', 'kelas', 'alamat', 'status'];

    public function pkls()
    {
        return $this->hasMany(PKL::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
