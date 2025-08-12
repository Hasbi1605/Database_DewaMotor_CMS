<?php

namespace App\Http\Controllers;

use App\Models\DokumenKendaraan;
use App\Models\Kendaraan;
use App\Services\DokumenKendaraanService;
use App\Http\Requests\DokumenKendaraanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DokumenKendaraanController extends Controller
{
    protected $dokumenKendaraanService;

    public function __construct(DokumenKendaraanService $dokumenKendaraanService)
    {
        $this->dokumenKendaraanService = $dokumenKendaraanService;
    }

    public function index(Request $request)
    {
        $kendaraans = Kendaraan::select(['id', 'nomor_polisi', 'merek', 'model'])->get();

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
        return view('paneladmin.dokumen-kendaraan.index', compact('dokumenKendaraans', 'kendaraans', 'kendaraans_page'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create(Request $request)
    {
        $kendaraans = Kendaraan::select(['id', 'nomor_polisi', 'merek', 'model'])->get();
        $selectedKendaraanId = $request->kendaraan_id;
        $selectedJenisDokumen = $request->jenis_dokumen;

        return view('paneladmin.dokumen-kendaraan.create', compact('kendaraans', 'selectedKendaraanId', 'selectedJenisDokumen'));
    }

    /**
     * Menyimpan resource yang baru dibuat ke storage.
     */
    public function store(DokumenKendaraanRequest $request)
    {
        // Get validated data from Form Request
        $validatedData = $request->validated();

        // Add file to validated data if exists
        if ($request->hasFile('file')) {
            $validatedData['file'] = $request->file('file');
        }

        // Create dokumen kendaraan using service
        $this->dokumenKendaraanService->createDokumenKendaraan($validatedData);

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
        try {
            Log::info('Menampilkan form edit untuk dokumen kendaraan dengan ID: ' . $id);
            $dokumenKendaraan = DokumenKendaraan::with('kendaraan')->findOrFail($id);
            $kendaraans = Kendaraan::select(['id', 'nomor_polisi', 'merek', 'model'])->get();
            return view('paneladmin.dokumen-kendaraan.edit', compact('dokumenKendaraan', 'kendaraans'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan form edit dokumen kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('dokumen-kendaraans.index')->with('error', 'Dokumen kendaraan tidak ditemukan.');
        }
    }

    /**
     * Memperbarui resource yang spesifik di storage.
     */
    public function update(DokumenKendaraanRequest $request, string $id)
    {
        try {
            Log::info('Memperbarui dokumen kendaraan dengan ID: ' . $id);
            $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Add file to validated data if exists
            if ($request->hasFile('file')) {
                $validatedData['file'] = $request->file('file');
            }

            // Update dokumen kendaraan using service
            $this->dokumenKendaraanService->updateDokumenKendaraan($validatedData, $dokumenKendaraan);

            return redirect()->route('dokumen-kendaraans.index')
                ->with('success', 'Dokumen kendaraan berhasil diperbarui');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui dokumen kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('dokumen-kendaraans.index')->with('error', 'Dokumen kendaraan tidak ditemukan.');
        }
    }

    /**
     * Menghapus resource yang spesifik dari storage.
     */
    public function destroy(string $id)
    {
        try {
            Log::info('Menghapus dokumen kendaraan dengan ID: ' . $id);
            $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

            // Delete dokumen kendaraan using service
            $this->dokumenKendaraanService->deleteDokumenKendaraan($dokumenKendaraan);

            return redirect()->route('dokumen-kendaraans.index')
                ->with('success', 'Dokumen kendaraan berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus dokumen kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('dokumen-kendaraans.index')->with('error', 'Dokumen kendaraan tidak ditemukan.');
        }
    }

    /**
     * Menghapus file dari dokumen kendaraan.
     */
    public function removeFile(string $id)
    {
        try {
            Log::info('Menghapus file dari dokumen kendaraan dengan ID: ' . $id);
            $dokumenKendaraan = DokumenKendaraan::findOrFail($id);

            // Remove file using service
            if ($this->dokumenKendaraanService->removeFile($dokumenKendaraan)) {
                return redirect()->route('dokumen-kendaraans.edit', $id)
                    ->with('success', 'File dokumen berhasil dihapus');
            }

            return redirect()->route('dokumen-kendaraans.edit', $id)
                ->with('error', 'File tidak ditemukan');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus file dokumen kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('dokumen-kendaraans.index')->with('error', 'Dokumen kendaraan tidak ditemukan.');
        }
    }
}
