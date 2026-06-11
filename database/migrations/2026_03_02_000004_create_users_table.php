<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id('id_user');
            $table->string('NIK')->unique();
            $table->string('nama_lengkap');
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_jabatan')->nullable();
            $table->unsignedBigInteger('id_unit_kerja')->nullable();
            $table->string('password');

            $table->rememberToken();

            $table->timestamps();

            $table->foreign('id_role')
                ->references('id_role')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('id_jabatan')
                ->references('id_jabatan')
                ->on('jabatans')
                ->onDelete('set null');

            $table->foreign('id_unit_kerja')
                ->references('id_unit_kerja')
                ->on('unit_kerjas')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};