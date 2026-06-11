<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keluars', function (Blueprint $table) {

            $table->id();
            $table->date('tanggal_keluar');
            $table->string('nomor_surat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->text('keterangan')->nullable();
            $table->string('file_scan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};