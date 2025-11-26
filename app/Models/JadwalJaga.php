<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;

class JadwalJaga extends Model
{
    /** @use HasFactory<\Database\Factories\JadwalJagaFactory> */
    use HasFactory;

    protected $fillable = [
        'petugas_id',
        'tanggal_jaga',
        'shift_mulai',
        'shift_selesai',
        'status',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }
}
