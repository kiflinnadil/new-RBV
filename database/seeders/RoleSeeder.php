<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            [
                'nama_role' => 'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'sekretaris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'unit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}