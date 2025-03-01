<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat user admin
        User::create([
            'email' => 'admin@example.com',
            'password' => 'Admin123',
            'role' => 'admin',
        ]);
        Admin::create([
            'email' => 'admin@example.com',
            'nip' => '0000000001',
            'nama' => 'Admin Utama',
            'telepon' => '0898769876',
            'alamat' => 'Palembang',
        ]);
    }
}
