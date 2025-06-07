<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Category;
use Illuminate\Http\Request;

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
            'categories' => 'array',
        ]);

        // Simpan data kendaraan ke database  
        $kendaraan = Kendaraan::create($validatedData);

        // Sinkronisasi kategori jika disediakan
        if ($request->has('categories')) {
            $kendaraan->categories()->attach($request->categories);
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
            'categories' => 'array',
        ]);

        $kendaraan = Kendaraan::find($id);
        if (!$kendaraan) {
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');
        }

        $kendaraan->update($validatedData);

        // Sinkronisasi kategori
        if ($request->has('categories')) {
            $kendaraan->categories()->sync($request->categories);
        } else {
            $kendaraan->categories()->detach();
        }

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
}
