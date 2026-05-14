<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'alamat' => 'Semarang',
                'no_hp' => '08123456789',
                'no_ktp' => '330101010101',
            ],
            [
                'nama' => 'Dokter',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter'),
                'role' => 'dokter',
                'alamat' => 'Semarang',
                'no_hp' => '08123456788',
                'no_ktp' => '330101010102',
            ],
            [
                'nama' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('pasien'),
                'role' => 'pasien', 
                'alamat' => 'Semarang',
                'no_hp' => '08123456787',
                'no_ktp' => '330101010103',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}