<?php

namespace App\Http\Controllers;

use App\Models\DokumenKendaraan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenKendaraanController extends Controller
{
    /**
     * Menghapus file dari storage jika ada
     */
    private function deleteFileIfExists($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return true;
        }
        return false;
    }

    public function index(Request $request)
    {
        $kendaraans = Kendaraan::all();


        $kendaraanQuery = Kendaraan::with(['dokumen' => function ($query) use ($request) {
            if ($request->has('search')) {
                $query->where('nomor_dokumen', 'like', "%{$request->search}%");
            }
        }])->orderByRaw("CASE WHEN status = 'tersedia' THEN 0 ELSE 1 END")
            ->latest();

        // Filter berdasarkan kendaraan
        if ($request->has('kendaraan_id') && $request->kendaraan_id != '') {
            $kendaraanQuery->where('id', $request->kendaraan_id);
        }

        // Dapatkan kendaraan dengan paginasi
        $kendaraans_page = $kendaraanQuery->latest()->paginate(10);

        // Transformasi paginator agar dapat bekerja dengan view yang ada
        $dokumenKendaraans = collect();
        foreach ($kendaraans_page as $kendaraan) {
            foreach ($kendaraan->dokumen as $dokumen) {
                $dokumenKendaraans->push($dokumen);
            }
        }

        // Kita akan memberikan paginator dan koleksi yang sudah ditransformasi
        return view('dokumen-kendaraans.index', compact('dokumenKendaraans', 'kendaraans', 'kendaraans_page'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create(Request $request)
    {
        $kendaraans = Kendaraan::all();
        $selectedKendaraanId = $request->kendaraan_id;
        $selectedJenisDokumen = $request->jenis_dokumen;

        return view('dokumen-kendaraans.create', compact('kendaraans', 'selectedKendaraanId', 'selectedJenisDokumen'));
    }

    /**
     * Menyimpan resource yang baru dibuat ke storage.
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
     * Menampilkan resource yang spesifik.
     */
    public function show(string $id)
    {
        return redirect()->route('dokumen-kendaraans.edit', $id);
    }

    /**
     * Menampilkan form untuk edit resource yang spesifik.
     */
    public function edit(string $id)
    {
        $dokumenKendaraan = DokumenKendaraan::findOrFail($id);
        $kendaraans = Kendaraan::all();
        return view('dokumen-kendaraans.edit', compact('dokumenKendaraan', 'kendaraans'));
    }

    /**
     * Memperbarui resource yang spesifik di storage.
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
            $this->deleteFileIfExists($dokumenKendaraan->file_path);

            $file = $request->file('file');
            $path = $file->store('dokumen-kendaraan', 'public');
            $data['file_path'] = $path;
        }

        $dokumenKendaraan->update($data);

        return redirect()->route('dokumen-kendaraans.index')
            ->with('success', 'Dokumen kendaraan berhasil diperbarui');
    }

    /**
     * Menghapus resource yang spesifik dari storage.
     */
    public function destroy(string $id)
    {
        $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

        // Hapus file jika ada
        $this->deleteFileIfExists($dokumenKendaraan->file_path);

        $dokumenKendaraan->delete();

        return redirect()->route('dokumen-kendaraans.index')
            ->with('success', 'Dokumen kendaraan berhasil dihapus');
    }

    /**
     * Menghapus file dari dokumen kendaraan.
     */
    public function removeFile(string $id)
    {
        $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

        // Hapus file jika ada
        if ($this->deleteFileIfExists($dokumenKendaraan->file_path)) {
            $dokumenKendaraan->update(['file_path' => null]);

            return redirect()->route('dokumen-kendaraans.edit', $id)
                ->with('success', 'File dokumen berhasil dihapus');
        }

        return redirect()->route('dokumen-kendaraans.edit', $id)
            ->with('error', 'File tidak ditemukan');
    }
}
