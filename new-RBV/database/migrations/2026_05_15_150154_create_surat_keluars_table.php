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
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_keluar');
            $table->string('tujuan');
            $table->string('perihal');
            $table->longText('isi')->nullable();
            $table->text('keterangan')->nullable();

            $table->enum('jenis', [
                'internal',
                'external'
            ])->default('internal');

            $table->enum('prioritas', [
                'biasa',
                'sedang',
                'segera'
            ])->default('biasa');


            $table->enum('status', [
                'draft',
                'disetujui'
            ])->default('disetujui');

            $table->string('file_scan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh');
            $table->foreign('dibuat_oleh')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};