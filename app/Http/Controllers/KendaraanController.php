<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
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
        $totalProfit = Kendaraan::getTotalProfit();
        $totalTerjual = Kendaraan::where('status', 'terjual')->count();
        $categories = Category::all();

        return view('kendaraans.index', compact('kendaraans', 'totalProfit', 'totalTerjual', 'categories'));
    }

    public function create()
    {
        $categories = Category::all()->groupBy('type');
        return view('kendaraans.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima  
        $validatedData = $request->validate([
            'nomor_rangka' => 'required|string|max:255',
            'nomor_mesin' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun_pembuatan' => 'required|integer',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'class_category' => 'nullable|exists:categories,id',
            'brand_category' => 'nullable|exists:categories,id',
            'document_category' => 'nullable|exists:categories,id',
            'condition_category' => 'nullable|exists:categories,id',
            'photos' => 'nullable|array|max:10', // Maksimal 10 foto
            'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048' // Setiap foto maksimal 2MB
        ]);

        // Tangani unggahan foto
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('kendaraan-photos', 'public');
                $photoPaths[] = $path;
            }
        }

        // Hapus validasi foto dari data utama
        unset($validatedData['photos']);

        // Tambahkan foto ke data yang divalidasi
        $validatedData['photos'] = $photoPaths;

        // Simpan data kendaraan ke database  
        $kendaraan = Kendaraan::create($validatedData);

        // Kumpulkan ID kategori dari field individual
        $categoryIds = array_filter([
            $request->class_category,
            $request->brand_category,
            $request->document_category,
            $request->condition_category
        ]);

        // Pasang kategori jika ada yang dipilih
        if (!empty($categoryIds)) {
            $kendaraan->categories()->attach($categoryIds);
        }

        // Redirect ke halaman daftar dengan pesan sukses  
        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kendaraan = Kendaraan::with(['dokumen', 'categories'])->find($id);
        if (!$kendaraan) {
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }

        // Dapatkan status dokumen
        $requiredDocs = ['STNK', 'BPKB', 'Faktur'];
        $existingDocs = $kendaraan->dokumen->pluck('jenis_dokumen')->toArray();
        $missingDocs = array_diff($requiredDocs, $existingDocs);

        return view('kendaraans.show', compact('kendaraan', 'missingDocs', 'requiredDocs'));
    }

    public function edit($id)
    {
        $kendaraan = Kendaraan::with('categories')->find($id);
        if (!$kendaraan) {
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }
        $categories = Category::all()->groupBy('type');
        return view('kendaraans.edit', compact('kendaraan', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nomor_rangka' => 'required|string|max:255',
            'nomor_mesin' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun_pembuatan' => 'required|integer',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'class_category' => 'nullable|exists:categories,id',
            'brand_category' => 'nullable|exists:categories,id',
            'document_category' => 'nullable|exists:categories,id',
            'condition_category' => 'nullable|exists:categories,id',
            'photos' => 'nullable|array|max:10', // Maksimal 10 foto
            'photos.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048' // Setiap foto maksimal 2MB
        ]);

        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }

        // Tangani unggahan foto
        $photoPaths = $kendaraan->photos ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('kendaraan-photos', 'public');
                $photoPaths[] = $path;
            }
        }

        // Hapus validasi foto dari data utama
        unset($validatedData['photos']);

        // Tambahkan foto ke data yang divalidasi
        $validatedData['photos'] = $photoPaths;

        $kendaraan->update($validatedData);

        // Kumpulkan ID kategori dari field individual
        $categoryIds = array_filter([
            $request->class_category,
            $request->brand_category,
            $request->document_category,
            $request->condition_category
        ]);

        // Sinkronkan kategori - ini akan menghapus yang lama dan menambahkan yang baru
        $kendaraan->categories()->sync($categoryIds);

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }

        $kendaraan->delete();

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }

        $kendaraan->status = $request->status;
        $kendaraan->save();

        return redirect()->back()->with('success', 'Status kendaraan berhasil diperbarui.');
    }

    /**
     * Menghapus foto dari kendaraan
     */
    public function removePhoto(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return response()->json(['error' => 'Kendaraan tidak ditemukan.'], 404);
        }

        $photoPath = $request->input('photo_path');

        // Remove from storage
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        // Remove from database
        $kendaraan->removePhoto($photoPath);

        return response()->json(['success' => 'Foto berhasil dihapus.']);
    }
}
