<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('id_buku');
            
            $table->string('judul');
            $table->string('penulis');
            $table->string('kategori');
            $table->year('tahun');
            $table->text('deskripsi');
            $table->string('file_pdf');
            $table->string('cover');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};