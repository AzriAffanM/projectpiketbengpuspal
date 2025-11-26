<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalJaga;

class Petugas extends Model
{
    /** @use HasFactory<\Database\Factories\PetugasFactory> */
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nama',
        'nrp',
        'pangkat',
        'jabatan',
        'nomor_telepon',
        'urutan',
    ];

    public function jadwalJagas()
    {
        return $this->hasMany(JadwalJaga::class, 'petugas_id');
    }
}
