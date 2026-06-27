<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pindahkan data unit_kerjas ke unit_kerja
        $oldUnits = DB::table('unit_kerjas')->get();
        foreach ($oldUnits as $unit) {
            DB::table('unit_kerja')->insertOrIgnore([
                'id' => $unit->id_unit_kerja,
                'unit_name' => $unit->nama_unit,
                'created_at' => $unit->created_at,
                'updated_at' => $unit->updated_at,
            ]);
        }

        // Pindahkan data unit_kerja_user ke user_unit_kerja
        $oldPivots = DB::table('unit_kerja_user')->get();
        foreach ($oldPivots as $pivot) {
            DB::table('user_unit_kerja')->insertOrIgnore([
                'user_id' => $pivot->id_user,
                'unit_kerja_id' => $pivot->id_unit_kerja,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus foreign key dan kolom id_unit_kerja di users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_unit_kerja']);
            $table->dropColumn('id_unit_kerja');
        });

        // Hapus pivot dan tabel lama
        Schema::dropIfExists('unit_kerja_user');
        Schema::dropIfExists('unit_kerjas');
    }

    public function down(): void
    {
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->id('id_unit_kerja');
            $table->string('nama_unit')->unique();
            $table->string('kabid')->nullable();
            $table->timestamps();
        });

        Schema::create('unit_kerja_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_unit_kerja');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_unit_kerja')->nullable();
            $table->foreign('id_unit_kerja')
                  ->references('id_unit_kerja')
                  ->on('unit_kerjas')
                  ->onDelete('set null');
        });
    }
};
