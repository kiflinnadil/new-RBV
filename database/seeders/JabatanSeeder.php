<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatans')->insert([

            [
                'nama_jabatan' => 'Direktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_jabatan' => 'Kepala Bagian',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_jabatan' => 'Kepala Unit',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_jabatan' => 'Sekretaris',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_jabatan' => 'Karyawan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}