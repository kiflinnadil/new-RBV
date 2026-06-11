<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persetujuans', function (Blueprint $table) {
            $table->id();

            $table->morphs('surat');
            $table->unsignedBigInteger('user_id');
            $table->enum('role_approver', [
                'direktur',
                'kabag'
            ]);

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'pending'
            ])->default('menunggu');

            $table->text('catatan')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->foreign('user_id')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuans');
    }
};