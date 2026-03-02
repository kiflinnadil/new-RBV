<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // primary key custom

            $table->string('NIK')->unique();
            $table->string('nama_lengkap');
            $table->string('jabatan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->enum('role', ['super_admin', 'admin', '?'])
                ->default('?');

            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
