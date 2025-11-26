<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class PetugasController extends Controller
{
    // Semua aksi diperbolehkan untuk user yang sudah login (dibatasi oleh group auth di routes)

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = Petugas::orderBy('urutan')->paginate(10);
        return view('petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nrp' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'urutan' => 'nullable|integer|min:1',
        ]);
        if (!isset($data['urutan'])) {
            $data['urutan'] = (Petugas::max('urutan') ?? 0) + 1;
        }
        $petugas = Petugas::create($data);
        return redirect()->route('petugas.show', $petugas)->with('success', 'Petugas ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Petugas $petugas)
    {
        return view('petugas.detail', compact('petugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petugas $petugas)
    {
        return view('petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petugas)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nrp' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:50',
            'urutan' => 'nullable|integer|min:1',
        ]);
        $petugas->update($data);
        return redirect()->route('petugas.index')->with('success', 'Petugas diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petugas)
    {
        $petugas->delete();
        return redirect()->route('petugas.index')->with('success', 'Petugas dihapus.');
    }
}

