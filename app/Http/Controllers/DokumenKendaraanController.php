<?php

namespace App\Http\Controllers;

use App\Models\DokumenKendaraan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get all kendaraans for the filter dropdown
        $kendaraans = Kendaraan::all();

        // Start with kendaraans that have documents
        $kendaraanQuery = Kendaraan::with(['dokumen' => function ($query) use ($request) {
            if ($request->has('search')) {
                $query->where('nomor_dokumen', 'like', "%{$request->search}%");
            }
        }])->has('dokumen');

        // Filter berdasarkan kendaraan
        if ($request->has('kendaraan_id') && $request->kendaraan_id != '') {
            $kendaraanQuery->where('id', $request->kendaraan_id);
        }

        // Get paginated kendaraans
        $kendaraans_page = $kendaraanQuery->latest()->paginate(10);

        // Transform the paginator to work with our existing view
        $dokumenKendaraans = collect();
        foreach ($kendaraans_page as $kendaraan) {
            foreach ($kendaraan->dokumen as $dokumen) {
                $dokumenKendaraans->push($dokumen);
            }
        }

        // We'll pass both the paginator and the transformed collection
        return view('dokumen-kendaraans.index', compact('dokumenKendaraans', 'kendaraans', 'kendaraans_page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kendaraans = Kendaraan::all();
        $selectedKendaraanId = $request->kendaraan_id;
        $selectedJenisDokumen = $request->jenis_dokumen;

        return view('dokumen-kendaraans.create', compact('kendaraans', 'selectedKendaraanId', 'selectedJenisDokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'jenis_dokumen' => 'required',
            'nomor_dokumen' => 'required',
            'tanggal_terbit' => 'required|date',
            'tanggal_expired' => 'nullable|date|after:tanggal_terbit',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('dokumen-kendaraan', 'public');
            $data['file_path'] = $path;
        }

        DokumenKendaraan::create($data);

        return redirect()->route('dokumen-kendaraans.index')
            ->with('success', 'Dokumen kendaraan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('dokumen-kendaraans.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokumenKendaraan = DokumenKendaraan::findOrFail($id);
        $kendaraans = Kendaraan::all();
        return view('dokumen-kendaraans.edit', compact('dokumenKendaraan', 'kendaraans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'jenis_dokumen' => 'required',
            'nomor_dokumen' => 'required',
            'tanggal_terbit' => 'required|date',
            'tanggal_expired' => 'nullable|date|after:tanggal_terbit',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($dokumenKendaraan->file_path && Storage::disk('public')->exists($dokumenKendaraan->file_path)) {
                Storage::disk('public')->delete($dokumenKendaraan->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('dokumen-kendaraan', 'public');
            $data['file_path'] = $path;
        }

        $dokumenKendaraan->update($data);

        return redirect()->route('dokumen-kendaraans.index')
            ->with('success', 'Dokumen kendaraan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

        // Hapus file jika ada
        if ($dokumenKendaraan->file_path && Storage::disk('public')->exists($dokumenKendaraan->file_path)) {
            Storage::disk('public')->delete($dokumenKendaraan->file_path);
        }

        $dokumenKendaraan->delete();

        return redirect()->route('dokumen-kendaraans.index')
            ->with('success', 'Dokumen kendaraan berhasil dihapus');
    }
}
