<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_pikets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_jaga_id')->constrained('jadwal_jagas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('foto_bukti');
            $table->text('deskripsi');
            $table->timestamp('waktu_selesai');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pikets');
    }
};
