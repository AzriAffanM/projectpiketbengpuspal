<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalJaga;
use App\Models\Petugas;

class JadwalJagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = JadwalJaga::with('petugas')
            ->select('jadwal_jagas.*')
            ->leftJoin('petugas', 'petugas.id', '=', 'jadwal_jagas.petugas_id')
            ->orderByDesc('jadwal_jagas.tanggal_jaga')
            ->orderBy('petugas.urutan')
            ->orderByDesc('jadwal_jagas.created_at')
            ->paginate(10);
        $allPetugas = Petugas::orderBy('urutan')->get();
        return view('jadwal_jaga.index', compact('jadwals', 'allPetugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petugas = Petugas::orderBy('nama')->get();
        return view('jadwal_jaga.create', compact('petugas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal_jaga' => 'required|date',
            'shift_mulai' => 'required',
            'shift_selesai' => 'required',
            'status' => 'nullable|in:Sedang Bertugas,Selesai',
        ]);
        $data['status'] = $data['status'] ?? 'Sedang Bertugas';
        $jadwal = JadwalJaga::create($data);
        return redirect()->route('jadwal-jaga.show', $jadwal)->with('success', 'Jadwal dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalJaga $jadwal_jaga)
    {
        $jadwal = $jadwal_jaga->load('petugas');
        $allPetugas = Petugas::orderBy('urutan')->get();
        return view('jadwal_jaga.detail', compact('jadwal', 'allPetugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalJaga $jadwal_jaga)
    {
        $petugas = Petugas::orderBy('nama')->get();
        $jadwal = $jadwal_jaga;
        return view('jadwal_jaga.edit', compact('jadwal', 'petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalJaga $jadwal_jaga)
    {
        $data = $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'tanggal_jaga' => 'required|date',
            'shift_mulai' => 'required',
            'shift_selesai' => 'required',
            'status' => 'required|in:Sedang Bertugas,Selesai',
        ]);
        $jadwal_jaga->update($data);
        return redirect()->route('jadwal-jaga.index')->with('success', 'Jadwal diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalJaga $jadwal_jaga)
    {
        $jadwal_jaga->delete();
        return redirect()->route('jadwal-jaga.index')->with('success', 'Jadwal dihapus.');
    }

    /**
     * Ambil 4 petugas teratas berdasarkan urutan saat ini.
     */
    protected function getNextGroupOfFour(): array
    {
        $ordered = Petugas::orderBy('urutan')->get();
        return $ordered->take(5)->all();
    }

    /**
     * Buat jadwal 4 orang untuk tanggal tertentu dengan opsi 1 orang skip yang digantikan otomatis.
     */
    protected function createDailySchedule(string $date, ?int $skipPetugasId = null): void
    {
        $ordered = Petugas::orderBy('urutan')->get();

        $selected = [];
        foreach ($ordered as $p) {
            if (count($selected) >= 5) {
                break;
            }
            // Jika yang bersangkutan adalah skip, lewati dulu
            if ($skipPetugasId && $p->id === $skipPetugasId) {
                continue;
            }
            $selected[] = $p;
        }

        // Jika masih kurang dari 5 karena skip berada di teratas, ambil tambahan dari sisa
        if (count($selected) < 5) {
            foreach ($ordered as $p) {
                if (count($selected) >= 5) {
                    break;
                }
                if (in_array($p->id, array_map(fn($x) => $x->id, $selected), true)) {
                    continue;
                }
                $selected[] = $p;
            }
        }

        foreach ($selected as $p) {
            JadwalJaga::firstOrCreate(
                [
                    'petugas_id' => $p->id,
                    'tanggal_jaga' => $date,
                ],
                [
                    'shift_mulai' => '19:00:00',
                    'shift_selesai' => '07:00:00',
                    'status' => 'Sedang Bertugas',
                ]
            );
        }
    }

    /**
     * Rotasi: pindahkan 4 petugas yang bertugas hari itu ke bawah (preserve order), lalu normalisasi urutan.
     */
    protected function rotateGroupToBottom(array $petugasIds): void
    {
        if (empty($petugasIds)) {
            return;
        }

        $maxUrutan = Petugas::max('urutan') ?? 0;

        // Urutkan sesuai urutan saat ini agar preservasi urutan terjaga
        $group = Petugas::whereIn('id', $petugasIds)->orderBy('urutan')->get();
        foreach ($group as $p) {
            $maxUrutan++;
            $p->urutan = $maxUrutan;
            $p->save();
        }

        // Normalisasi urutan mulai dari 1
        $ordered = Petugas::orderBy('urutan')->get();
        $i = 1;
        foreach ($ordered as $p) {
            if ($p->urutan !== $i) {
                $p->urutan = $i;
                $p->save();
            }
            $i++;
        }
    }

    /**
     * Tandai selesai satu jadwal. Jika semua 4 jadwal pada tanggal itu selesai, lakukan rotasi dan buat jadwal besok untuk 4 orang berikutnya.
     */
    public function selesai(Request $request, JadwalJaga $jadwal)
    {
        if ($jadwal->status === 'Selesai') {
            return back()->with('info', 'Jadwal ini sudah selesai.');
        }

        $jadwal->update(['status' => 'Selesai']);

        // Cek apakah seluruh orang pada tanggal yang sama sudah selesai
        $tanggal = $jadwal->tanggal_jaga;
        $remaining = JadwalJaga::where('tanggal_jaga', $tanggal)
            ->where('status', 'Sedang Bertugas')
            ->count();

        if ($remaining === 0) {
            // Kumpulkan id petugas yang bertugas hari ini (maks 5)
            $groupIds = JadwalJaga::where('tanggal_jaga', $tanggal)
                ->orderBy('id')
                ->limit(5)
                ->pluck('petugas_id')
                ->toArray();

            // Rotasi 4 orang ke bawah
            $this->rotateGroupToBottom($groupIds);

            // Jadwalkan otomatis orang besok
            $nextDate = \Carbon\Carbon::parse($tanggal)->addDay()->toDateString();
            $skipId = $request->input('skip_petugas_id'); // opsional: jika ada 1 orang berhalangan besok
            $this->createDailySchedule($nextDate, $skipId ? (int)$skipId : null);
        }

        return back()->with('success', 'Status diset selesai.' . ($remaining === 0 ? ' Jadwal berikutnya dibuat untuk 5 orang.' : ''));
    }

    /**
     * Gantikan petugas yang berhalangan pada HARI YANG SAMA dengan orang pertama dari kelompok 4 berikutnya.
     * Tidak mengubah status jadwal; hanya mengganti petugas_id pada record jadwal terkait.
     */
    public function gantikan(Request $request, JadwalJaga $jadwal)
    {
        if ($jadwal->status !== 'Sedang Bertugas') {
            return back()->with('info', 'Hanya jadwal yang sedang bertugas yang dapat digantikan.');
        }

        $tanggal = $jadwal->tanggal_jaga;
        $todayIds = JadwalJaga::where('tanggal_jaga', $tanggal)->pluck('petugas_id')->toArray();

        if (count($todayIds) === 0) {
            return back()->with('info', 'Tidak ada kelompok aktif untuk digantikan.');
        }

        // Urutan tertinggi pada kelompok hari ini
        $topGroup = Petugas::whereIn('id', $todayIds)->orderBy('urutan')->get();
        $lastUrutan = $topGroup->max('urutan');

        // Cari kandidat pertama setelah kelompok ini yang belum dijadwalkan hari ini
        $candidate = Petugas::where('urutan', '>', $lastUrutan)
            ->whereNotIn('id', $todayIds)
            ->orderBy('urutan')
            ->first();

        // Jika tidak ada (wrap-around), ambil dari awal
        if (!$candidate) {
            $candidate = Petugas::whereNotIn('id', $todayIds)
                ->orderBy('urutan')
                ->first();
        }

        if (!$candidate) {
            return back()->with('info', 'Tidak ada kandidat pengganti tersedia.');
        }

        // Pastikan tidak ada duplikasi jadwal untuk kandidat pada tanggal yang sama
        $exists = JadwalJaga::where('tanggal_jaga', $tanggal)
            ->where('petugas_id', $candidate->id)
            ->exists();
        if ($exists) {
            return back()->with('info', 'Pengganti sudah terjadwal hari ini.');
        }

        // Gantikan petugas pada jadwal ini
        $jadwal->petugas_id = $candidate->id;
        $jadwal->save();

        return back()->with('success', 'Petugas digantikan oleh ' . $candidate->nama . ' untuk tanggal ' . $tanggal . '.');
    }
}
