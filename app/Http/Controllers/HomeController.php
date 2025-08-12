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
            // Query untuk kendaraan tersedia dengan pagination dan eager loading
            $queryTersedia = Kendaraan::with(['categories'])
                ->select(['id', 'nomor_polisi', 'merek', 'model', 'tahun_pembuatan', 'harga_jual', 'status', 'photos'])
                ->where('status', 'tersedia');

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

            // Query untuk kendaraan terjual dengan pagination dan eager loading
            $queryTerjual = Kendaraan::with(['categories'])
                ->select(['id', 'nomor_polisi', 'merek', 'model', 'tahun_pembuatan', 'harga_jual', 'harga_modal', 'status', 'photos'])
                ->where('status', 'terjual')
                ->orderBy('id', 'desc');
            $kendaraanTerjual = $queryTerjual->paginate(10, ['*'], 'terjual');
            $kendaraanTerjual->appends($request->query());

            // Data untuk statistik (tanpa pagination)
            $totalKendaraan = Kendaraan::count();
            $totalTerjual = Kendaraan::where('status', 'terjual')->count();
            $totalProfit = Kendaraan::getTotalProfit();
            $categories = Category::all();

            // Data untuk chart (kendaraan terjual semua) - optimized with specific fields
            $kendaraanTerjualAll = Kendaraan::with(['categories'])
                ->select(['id', 'harga_modal', 'harga_jual', 'created_at'])
                ->where('status', 'terjual')
                ->get();

            // Data untuk statistik penjualan berdasarkan semua kategori
            $classCategories = Category::where('type', 'class')->get();
            $brandCategories = Category::where('type', 'brand')->get();
            $documentCategories = Category::where('type', 'document')->get();
            $conditionCategories = Category::where('type', 'condition')->get();

            $salesByClass = [];
            $salesByBrand = [];
            $salesByDocument = [];
            $salesByCondition = [];

            // Penjualan berdasarkan kategori kelas
            foreach ($classCategories as $category) {
                $soldVehicles = Kendaraan::where('status', 'terjual')
                    ->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    })
                    ->count();
                $salesByClass[$category->name] = $soldVehicles;
            }

            // Penjualan berdasarkan kategori merek
            foreach ($brandCategories as $category) {
                $soldVehicles = Kendaraan::where('status', 'terjual')
                    ->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    })
                    ->count();
                $salesByBrand[$category->name] = $soldVehicles;
            }

            // Penjualan berdasarkan kategori dokumen
            foreach ($documentCategories as $category) {
                $soldVehicles = Kendaraan::where('status', 'terjual')
                    ->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    })
                    ->count();
                $salesByDocument[$category->name] = $soldVehicles;
            }

            // Penjualan berdasarkan kategori kondisi
            foreach ($conditionCategories as $category) {
                $soldVehicles = Kendaraan::where('status', 'terjual')
                    ->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    })
                    ->count();
                $salesByCondition[$category->name] = $soldVehicles;
            }

            // Data untuk komposisi kendaraan per kategori berdasarkan tipe
            $vehiclesByClass = [];
            $vehiclesByBrand = [];
            $vehiclesByDocument = [];
            $vehiclesByCondition = [];

            // Kategori Kelas (class)
            foreach ($classCategories as $category) {
                $totalVehicles = Kendaraan::whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                })->count();
                $vehiclesByClass[$category->name] = $totalVehicles;
            }

            // Kategori Merek (brand)
            foreach ($brandCategories as $category) {
                $totalVehicles = Kendaraan::whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                })->count();
                $vehiclesByBrand[$category->name] = $totalVehicles;
            }

            // Kategori Dokumen (document)
            foreach ($documentCategories as $category) {
                $totalVehicles = Kendaraan::whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                })->count();
                $vehiclesByDocument[$category->name] = $totalVehicles;
            }

            // Kategori Kondisi (condition)
            foreach ($conditionCategories as $category) {
                $totalVehicles = Kendaraan::whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                })->count();
                $vehiclesByCondition[$category->name] = $totalVehicles;
            }

            // Data untuk aktivitas penambahan kendaraan (12 bulan terakhir)
            $vehicleAdditionData = $this->getVehicleAdditionData();

            // Debug: Log the vehicle addition data
            Log::info('Vehicle Addition Data:', [
                'monthly_total' => collect($vehicleAdditionData['monthly'])->sum('count'),
                'weekly_total' => collect($vehicleAdditionData['weekly'])->sum('count'),
                'current_month' => collect($vehicleAdditionData['monthly'])->last(),
                'current_week' => collect($vehicleAdditionData['weekly'])->last()
            ]);

            // Data untuk kendaraan termahal dan termurah
            $expensiveVehicles = Kendaraan::where('status', 'tersedia')
                ->orderBy('harga_jual', 'desc')
                ->limit(5)
                ->get();

            $cheapestVehicles = Kendaraan::where('status', 'tersedia')
                ->orderBy('harga_jual', 'asc')
                ->limit(5)
                ->get();

            return view('paneladmin.dashboard.index', compact(
                'kendaraans',
                'totalKendaraan',
                'totalTerjual',
                'totalProfit',
                'kendaraanTerjual',
                'kendaraanTerjualAll',
                'categories',
                'salesByClass',
                'salesByBrand',
                'salesByDocument',
                'salesByCondition',
                'vehiclesByClass',
                'vehiclesByBrand',
                'vehiclesByDocument',
                'vehiclesByCondition',
                'vehicleAdditionData',
                'expensiveVehicles',
                'cheapestVehicles'
            ));
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

    /**
     * Get vehicle addition data for the last 12 months
     * 
     * @return array
     */
    private function getVehicleAdditionData()
    {
        $monthlyData = [];
        $weeklyData = [];

        Log::info('Getting vehicle addition data...');

        // Get monthly data for the last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');

            $count = Kendaraan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $monthlyData[] = [
                'period' => $monthYear,
                'count' => $count,
                'full_date' => $date->format('Y-m')
            ];

            // Log current month's data specifically
            if ($date->format('Y-m') === now()->format('Y-m')) {
                Log::info("Current month ({$monthYear}) vehicle count: {$count}");
            }
        }

        // Get weekly data for the last 12 weeks
        for ($i = 11; $i >= 0; $i--) {
            $startDate = now()->subWeeks($i)->startOfWeek();
            $endDate = now()->subWeeks($i)->endOfWeek();

            $weekLabel = 'Minggu ' . $startDate->format('d M') . ' - ' . $endDate->format('d M');

            $count = Kendaraan::whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $weeklyData[] = [
                'period' => $weekLabel,
                'count' => $count,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d')
            ];

            // Log current week's data specifically
            if ($startDate <= now() && $endDate >= now()) {
                Log::info("Current week ({$weekLabel}) vehicle count: {$count}");
            }
        }

        Log::info('Vehicle addition data summary:', [
            'monthly_entries' => count($monthlyData),
            'weekly_entries' => count($weeklyData),
            'total_monthly' => collect($monthlyData)->sum('count'),
            'total_weekly' => collect($weeklyData)->sum('count')
        ]);

        return [
            'monthly' => $monthlyData,
            'weekly' => $weeklyData
        ];
    }
}
