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
        Schema::create('jadwal_jagas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('petugas')->cascadeOnDelete();
            $table->date('tanggal_jaga');
            $table->time('shift_mulai');
            $table->time('shift_selesai');
            $table->enum('status', ['Sedang Bertugas', 'Selesai'])->default('Sedang Bertugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_jagas');
    }
};
