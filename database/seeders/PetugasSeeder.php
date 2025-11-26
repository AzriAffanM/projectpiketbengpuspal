<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Petugas;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Andi Setiawan', 'pangkat' => 'Sersan', 'jabatan' => 'Petugas', 'nomor_telepon' => '081234567890'],
            ['nama' => 'Budi Pratama', 'pangkat' => 'Kopral', 'jabatan' => 'Petugas', 'nomor_telepon' => '081298765432'],
            ['nama' => 'Citra Lestari', 'pangkat' => 'Sersan', 'jabatan' => 'Petugas', 'nomor_telepon' => '081377788899'],
        ];

        $urutan = 1;
        foreach ($data as $row) {
            $row['urutan'] = $urutan++;
            Petugas::firstOrCreate(['nama' => $row['nama']], $row);
        }
    }
}
