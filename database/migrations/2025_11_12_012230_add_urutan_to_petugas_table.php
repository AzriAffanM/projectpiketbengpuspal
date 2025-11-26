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
        Schema::table('petugas', function (Blueprint $table) {
            $table->unsignedInteger('urutan')->default(1)->after('nomor_telepon');
            $table->index('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petugas', function (Blueprint $table) {
            $table->dropIndex(['urutan']);
            $table->dropColumn('urutan');
        });
    }
};
