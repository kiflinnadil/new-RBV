<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_agenda')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->dateTime('tanggal_masuk')->nullable();
            $table->string('asal_surat');
            $table->text('perihal');
            $table->enum('jenis', ['internal', 'external']);
            $table->enum('prioritas', [
                'biasa',
                'sedang',
                'segera'
            ])->nullable();

            $table->text('catatan')->nullable();
            $table->text('catatan_tolak')->nullable();
            $table->text('catatan_pending')->nullable();

            $table->string('file_scan')->nullable();

            $table->enum('status', [
                'menunggu_sekretaris',
                'menunggu_direktur',
                'menunggu_kabag',
                'pending',
                'disetujui',
                'ditolak'
            ])->default('menunggu_sekretaris');

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
        Schema::dropIfExists('surat_masuks');
    }
};