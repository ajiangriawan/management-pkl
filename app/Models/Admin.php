<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admins';

    protected $fillable = ['nip', 'nama', 'email', 'telepon', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    
}
