<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id('id_video');

            $table->string('judul');
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->string('file_url');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video');
    }
};
