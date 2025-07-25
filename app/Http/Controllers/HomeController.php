<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info('Mengakses halaman home/dashboard');
            // Query untuk kendaraan tersedia dengan pagination
            $queryTersedia = Kendaraan::where('status', 'tersedia');

            // Terapkan filter kategori jika dipilih
            if ($request->filled('category')) {
                $queryTersedia->whereHas('categories', function ($q) use ($request) {
                    $q->where('categories.id', $request->category);
                });
            }

            // Mengurutkan kendaraan berdasarkan ID dari terbesar ke terkecil
            $queryTersedia->orderBy('id', 'desc');

            // Pagination untuk kendaraan tersedia
            $kendaraans = $queryTersedia->paginate(10, ['*'], 'tersedia');
            $kendaraans->appends($request->query());

            // Query untuk kendaraan terjual dengan pagination
            $queryTerjual = Kendaraan::where('status', 'terjual')->orderBy('id', 'desc');
            $kendaraanTerjual = $queryTerjual->paginate(10, ['*'], 'terjual');
            $kendaraanTerjual->appends($request->query());

            // Data untuk statistik (tanpa pagination)
            $totalKendaraan = Kendaraan::count();
            $totalTerjual = Kendaraan::where('status', 'terjual')->count();
            $totalProfit = Kendaraan::getTotalProfit();
            $categories = Category::all();

            // Data untuk chart (kendaraan terjual semua)
            $kendaraanTerjualAll = Kendaraan::where('status', 'terjual')->get();

            // Data untuk statistik penjualan berdasarkan kelas kategori
            $classCategories = Category::where('type', 'class')->get();
            $salesByClass = [];

            foreach ($classCategories as $category) {
                $soldVehicles = Kendaraan::where('status', 'terjual')
                    ->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    })
                    ->count();

                $salesByClass[$category->name] = $soldVehicles;
            }

            return view('paneladmin.dashboard.index', compact('kendaraans', 'totalKendaraan', 'totalTerjual', 'totalProfit', 'kendaraanTerjual', 'kendaraanTerjualAll', 'categories', 'salesByClass'));
        } catch (\Exception $e) {
            Log::error("Error saat mengakses halaman home: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat halaman.');
        }
    }
}
