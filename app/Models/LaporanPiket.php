<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalJaga;
use App\Models\User;

class LaporanPiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_jaga_id',
        'user_id',
        'foto_bukti',
        'deskripsi',
        'waktu_selesai',
        'status',
    ];

    protected $casts = [
        'waktu_selesai' => 'datetime',
    ];

    public function jadwalJaga()
    {
        return $this->belongsTo(JadwalJaga::class, 'jadwal_jaga_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
