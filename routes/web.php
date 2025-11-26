<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\JadwalJaga;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\JadwalJagaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\LaporanPiketController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $today = now()->toDateString();

        // Ambil jadwal yang statusnya masih aktif (Sedang Bertugas) terbaru terlebih dahulu
        $jadwalHariIni = JadwalJaga::with('petugas')
            ->where('status', 'Sedang Bertugas')
            ->orderByDesc('tanggal_jaga')
            ->orderByDesc('created_at')
            ->first();

        // Jika tidak ada yang aktif, coba ambil jadwal tepat untuk hari ini
        if (!$jadwalHariIni) {
            $jadwalHariIni = JadwalJaga::with('petugas')
                ->whereDate('tanggal_jaga', $today)
                ->orderBy('created_at')
                ->first();
        }

        // Jika tetap tidak ada, buat otomatis untuk hari ini dengan petugas urutan terkecil
        if (!$jadwalHariIni) {
            $aktif = Petugas::orderBy('urutan')->first();
            if ($aktif) {
                $jadwalHariIni = JadwalJaga::create([
                    'petugas_id' => $aktif->id,
                    'tanggal_jaga' => $today,
                    'shift_mulai' => '19:00:00',
                    'shift_selesai' => '07:00:00',
                    'status' => 'Sedang Bertugas',
                ]);
                $jadwalHariIni->load('petugas');
            }
        }

        $status = $jadwalHariIni && $jadwalHariIni->status === 'Sedang Bertugas' ? 'Sedang Bertugas' : 'Belum Bertugas';

        // Daftar semua petugas untuk ditampilkan di dashboard
        $daftarPetugas = Petugas::orderBy('urutan')->get();

        return view('dashboard', compact('jadwalHariIni', 'status', 'daftarPetugas'));
    })->name('dashboard');

    // Petugas: gunakan satu resource, pembatasan admin ditangani di controller
    Route::resource('petugas', PetugasController::class)
        ->parameters(['petugas' => 'petugas']);
    Route::resource('jadwal-jaga', JadwalJagaController::class);
    Route::post('jadwal-jaga/{jadwal}/selesai', [JadwalJagaController::class, 'selesai'])->name('jadwal-jaga.selesai');
    Route::post('jadwal-jaga/{jadwal}/gantikan', [JadwalJagaController::class, 'gantikan'])->name('jadwal-jaga.gantikan');

    Route::get('jadwal-jaga/{jadwal}/laporan', [LaporanPiketController::class, 'createFromJadwal'])->name('laporan-piket.create-from-jadwal');
    Route::post('jadwal-jaga/{jadwal}/laporan', [LaporanPiketController::class, 'storeFromJadwal'])->name('laporan-piket.store-from-jadwal');

    Route::get('laporan-piket/approval', [LaporanPiketController::class, 'approvalIndex'])->name('laporan-piket.approval');
    Route::post('laporan-piket/{laporan}/approve', [LaporanPiketController::class, 'approve'])->name('laporan-piket.approve');
    Route::post('laporan-piket/{laporan}/reject', [LaporanPiketController::class, 'reject'])->name('laporan-piket.reject');
    Route::get('laporan-piket', [LaporanPiketController::class, 'index'])->name('laporan-piket.index');
    Route::get('laporan-piket-admin', [LaporanPiketController::class, 'adminIndex'])->name('laporan-piket.admin-index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
