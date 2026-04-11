<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
        $table->id('id_favorite');
        $table->foreignId('id_user')->references('id_user')->on('users')->cascadeOnDelete();
        $table->foreignId('id_buku')->references('id_buku')->on('bukus')->cascadeOnDelete();
        $table->timestamps();

        $table->unique(['id_user','id_buku']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
