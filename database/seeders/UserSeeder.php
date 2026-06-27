<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'NIK' => '1234567',
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
                'id_role' => 1,
                'id_jabatan' => 1,
                'id_unit_kerja' => 1,
            ],
            [
                'NIK' => '12345',
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'id_role' => 2,
                'id_jabatan' => 2,
                'id_unit_kerja' => 1,
            ],
            [
                'NIK' => '1234',
                'name' => 'Sekretaris',
                'password' => Hash::make('sekretaris123'),
                'id_role' => 3,
                'id_jabatan' => 4,
                'id_unit_kerja' => 33,
            ],
            [
                'NIK' => '123',
                'name' => 'Karyawan',
                'password' => Hash::make('karyawan123'),
                'id_role' => 4,
                'id_jabatan' => 5,
                'id_unit_kerja' => 30,
            ],
        ];

        foreach ($users as $userData) {
            $user = \App\Models\User::create([
                'NIK' => $userData['NIK'],
                'name' => $userData['name'],
                'password' => $userData['password'],
            ]);

            $user->roles()->sync([$userData['id_role']]);
            $user->jabatans()->sync([$userData['id_jabatan']]);
            $user->unitKerjas()->sync([$userData['id_unit_kerja']]);
        }
    }
}