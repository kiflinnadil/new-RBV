<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_surats', function (Blueprint $table) {
            $table->id();

            $table->morphs('surat');
            $table->unsignedBigInteger('user_id');
            $table->string('aksi');
            $table->text('keterangan')->nullable();

            $table->foreign('user_id')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_surats');
    }
};