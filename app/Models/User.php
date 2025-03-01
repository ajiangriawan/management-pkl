<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    // Kolom yang dapat diisi
    protected $fillable = [
        'password',
        'role',
        'email',
    ];

    // Kolom yang harus disembunyikan dari array dan JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Kolom yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    /**
     * Relasi dengan model Assessment
     * Seorang User dapat memiliki banyak penilaian (assessments)
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'penilai_id');
    }

    /**
     * Relasi dengan model Teacher
     * Seorang User dapat menjadi seorang Guru Pembimbing
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'email', 'email');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'email', 'email');
    }

    /**
     * Relasi dengan model Student
     * Seorang User dapat menjadi seorang Siswa
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'email', 'email');
    }

    /**
     * Relasi dengan model IndustryMentor
     * Seorang User dapat menjadi Pembimbing Industri
     */
    public function industryMentor()
    {
        return $this->hasOne(IndustryMentor::class);
    }

    /**
     * Mengatur password sebelum disimpan ke database
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Mengatur role user
     */
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isStudent()
    {
        return $this->role === 'Siswa';
    }

    public function isTeacher()
    {
        return $this->role === 'Guru Pembimbing';
    }

    public function isIndustryMentor()
    {
        return $this->role === 'Pembimbing Industri';
    }
}
