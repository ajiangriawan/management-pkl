<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryMentor extends Model
{
    use HasFactory;
    protected $table = 'industry_mentors';

    protected $fillable = [
        'industri_id',
        'nama',
        'email',
        'telepon',
        'alamat',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industri_id'); // Sesuaikan dengan nama foreign key di tabel
    }

    public function pkls()
    {
        return $this->hasMany(PKL::class, 'industri_id');
    }
}
