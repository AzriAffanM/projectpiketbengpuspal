<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LaporanPiket;
use App\Models\JadwalJaga;

class LaporanPiketController extends Controller
{
    public function createFromJadwal(JadwalJaga $jadwal)
    {
        $jadwal->load('petugas');

        return view('laporan_piket.create', compact('jadwal'));
    }

    public function storeFromJadwal(Request $request, JadwalJaga $jadwal)
    {
        $data = $request->validate([
            'foto_bukti' => 'required|image|max:2048',
            'deskripsi' => 'required|string',
        ]);

        $path = $request->file('foto_bukti')->store('laporan_piket', 'public');

        LaporanPiket::create([
            'jadwal_jaga_id' => $jadwal->id,
            'user_id' => Auth::id(),
            'foto_bukti' => $path,
            'deskripsi' => $data['deskripsi'],
            'waktu_selesai' => now(),
            'status' => 'pending',
        ]);

        app(JadwalJagaController::class)->selesai($request, $jadwal);

        return redirect()->route('laporan-piket.index')->with('success', 'Laporan piket dikirim dan menunggu persetujuan.');
    }

    public function approvalIndex()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $laporans = LaporanPiket::with(['jadwalJaga.petugas', 'user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('laporan_piket.approval', compact('laporans'));
    }

    public function approve(LaporanPiket $laporan)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $laporan->update(['status' => 'approved']);

        return back()->with('success', 'Laporan piket disetujui.');
    }

    public function reject(LaporanPiket $laporan)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $laporan->update(['status' => 'rejected']);

        return back()->with('success', 'Laporan piket ditolak.');
    }

    public function index()
    {
        $query = LaporanPiket::with(['jadwalJaga.petugas', 'user'])
            ->orderByDesc('waktu_selesai');

        if (!Auth::user() || Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $laporans = $query->paginate(10);

        return view('laporan_piket.index', compact('laporans'));
    }

    public function adminIndex()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $laporans = LaporanPiket::with(['jadwalJaga.petugas', 'user'])
            ->where('status', 'approved')
            ->orderByDesc('waktu_selesai')
            ->paginate(10);

        return view('laporan_piket.admin_index', compact('laporans'));
    }
}
