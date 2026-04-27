<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'kategori_unit')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('kategori_unit')->nullable()->after('unit_kerja');
            });
        }

        $mapping = [

            'Unit Poliklinik Rawat Jalan' => 'Kabid Keperawatan',
            'Instalasi Gawat Darurat' => 'Kabid Keperawatan',
            'Unit Rawat Inap Ruang Lotus' => 'Kabid Keperawatan',
            'Unit Rawat Inap Ruang Rosalina' => 'Kabid Keperawatan',
            'Unit Rawat Inap Ruang Alamanda' => 'Kabid Keperawatan',
            'Unit Rawat Inap Ruang Teratai' => 'Kabid Keperawatan',
            'Unit Rawat Inap Ruang Anturium' => 'Kabid Keperawatan',
            'Unit Rawat Inap Ruang Tulip' => 'Kabid Keperawatan',
            'Unit Kamar Operasi' => 'Kabid Keperawatan',
            'Unit ICU' => 'Kabid Keperawatan',
            'Unit Hemodialisis' => 'Kabid Keperawatan',
            'Unit Kamar Bersalin' => 'Kabid Keperawatan',
            'Unit Perinatologi' => 'Kabid Keperawatan',

            'Unit Radiologi' => 'Kabid Penunjang Medis',
            'Unit Laboratorium' => 'Kabid Penunjang Medis',
            'Unit Gizi' => 'Kabid Penunjang Medis',
            'Unit Farmasi' => 'Kabid Penunjang Medis',
            'Unit Rekam Medik' => 'Kabid Penunjang Medis',

            'Unit Umum Rumah Tangga' => 'Kabag Umum & Keuangan',
            'Unit Informasi & TI' => 'Kabag Umum & Keuangan',
            'Unit Keuangan' => 'Kabag Umum & Keuangan',
            'Unit Pajak' => 'Kabag Umum & Keuangan',
            'Unit Akuntansi' => 'Kabag Umum & Keuangan',
            'Unit Kepegawaian & Diklat' => 'Kabag Umum & Keuangan',
        ];

        foreach ($mapping as $unitKerja => $kategori) {
            User::where('unit_kerja', $unitKerja)
                ->update(['kategori_unit' => $kategori]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('kategori_unit');
        });
    }
};
