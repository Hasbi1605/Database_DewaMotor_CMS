<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Category;
use App\Services\KendaraanService;
use App\Repositories\KendaraanRepository;
use App\Http\Requests\KendaraanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KendaraanController extends Controller
{
    protected $kendaraanService;
    protected $kendaraanRepository;

    public function __construct(KendaraanService $kendaraanService, KendaraanRepository $kendaraanRepository)
    {
        $this->kendaraanService = $kendaraanService;
        $this->kendaraanRepository = $kendaraanRepository;
    }
    public function index(Request $request)
    {
        $query = Kendaraan::with(['dokumen', 'categories'])
            ->orderByRaw("CASE WHEN status = 'tersedia' THEN 0 ELSE 1 END")
            ->latest();

        // Pencarian berdasarkan nomor rangka, mesin, atau polisi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_rangka', 'like', "%{$search}%")
                    ->orWhere('nomor_mesin', 'like', "%{$search}%")
                    ->orWhere('nomor_polisi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter berdasarkan merek
        if ($request->filled('merek')) {
            $query->where('merek', $request->merek);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->where('tahun_pembuatan', $request->tahun);
        }

        // Filter berdasarkan range harga
        if ($request->filled('harga_min')) {
            $query->where('harga_jual', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_jual', '<=', $request->harga_max);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kendaraans = $query->paginate(10);

        // Optimized queries - Use raw SQL for simple counts and calculations
        $totalProfit = Kendaraan::getTotalProfit();
        $totalTerjual = Kendaraan::where('status', 'terjual')->count();
        $categories = cache()->remember('categories_all', 3600, function () {
            return Category::all();
        });

        return view('paneladmin.kelola-kendaraan.index', compact('kendaraans', 'totalProfit', 'totalTerjual', 'categories'));
    }

    public function create()
    {
        $categories = Category::all()->groupBy('type');
        return view('paneladmin.kelola-kendaraan.create', compact('categories'));
    }

    public function store(KendaraanRequest $request)
    {
        // Get validated data from Form Request
        $validatedData = $request->validated();

        // Add photos to validated data if they exist
        if ($request->hasFile('photos')) {
            $validatedData['photos'] = $request->file('photos');
        }

        // Create kendaraan using service
        $this->kendaraanService->createKendaraan($validatedData);

        // Redirect ke halaman daftar dengan pesan sukses  
        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show($id)
    {
        try {
            Log::info('Menampilkan kendaraan dengan ID: ' . $id);
            $kendaraan = Kendaraan::with(['dokumen', 'categories'])->findOrFail($id);

            // Dapatkan status dokumen
            $requiredDocs = ['STNK', 'BPKB', 'Faktur'];
            $existingDocs = $kendaraan->dokumen->pluck('jenis_dokumen')->toArray();
            $missingDocs = array_diff($requiredDocs, $existingDocs);

            return view('paneladmin.kelola-kendaraan.show', compact('kendaraan', 'missingDocs', 'requiredDocs'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }
    }

    public function edit($id)
    {
        try {
            Log::info('Menampilkan form edit untuk kendaraan dengan ID: ' . $id);
            $kendaraan = Kendaraan::with(['categories', 'dokumen'])->findOrFail($id);
            $categories = Category::all()->groupBy('type');
            return view('paneladmin.kelola-kendaraan.edit', compact('kendaraan', 'categories'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan form edit kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }
    }

    public function update(KendaraanRequest $request, $id)
    {
        try {
            Log::info('Memperbarui kendaraan dengan ID: ' . $id);

            // Get validated data from Form Request
            $validatedData = $request->validated();

            $kendaraan = Kendaraan::findOrFail($id);

            // Add photos to validated data if they exist
            if ($request->hasFile('photos')) {
                $validatedData['photos'] = $request->file('photos');
            }

            // Update kendaraan using service
            $this->kendaraanService->updateKendaraan($validatedData, $kendaraan);

            return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Menghapus kendaraan dengan ID: ' . $id);
            $kendaraan = Kendaraan::with(['dokumen', 'categories'])->findOrFail($id);
            $kendaraan->delete();

            return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil dihapus.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            Log::info('Memperbarui status kendaraan dengan ID: ' . $id);
            $kendaraan = Kendaraan::findOrFail($id);

            // Update status using service
            $this->kendaraanService->updateStatus($kendaraan, $request->status);

            return redirect()->back()->with('success', 'Status kendaraan berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui status kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }
    }

    /**
     * Menghapus foto dari kendaraan
     */
    public function removePhoto(Request $request, $id)
    {
        try {
            Log::info('Menghapus foto kendaraan dengan ID: ' . $id);
            $kendaraan = Kendaraan::findOrFail($id);

            $photoPath = $request->input('photo_path');

            // Remove photo using service
            $this->kendaraanService->removePhoto($kendaraan, $photoPath);

            return response()->json(['success' => 'Foto berhasil dihapus.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus foto kendaraan: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json(['error' => 'Kendaraan tidak ditemukan.'], 404);
        }
    }
}
