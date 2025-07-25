<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info('Mengakses halaman store/toko');
            $query = Kendaraan::with(['categories'])
                ->where('status', 'tersedia');

            // Filter berdasarkan kategori
            if ($request->filled('category')) {
                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('categories.id', $request->category);
                });
            }

            // Filter berdasarkan merek
            if ($request->filled('brand')) {
                $query->where('merek', 'like', '%' . $request->brand . '%');
            }

            // Filter berdasarkan rentang harga
            if ($request->filled('min_price')) {
                $query->where('harga_jual', '>=', $request->min_price);
            }

            if ($request->filled('max_price')) {
                $query->where('harga_jual', '<=', $request->max_price);
            }

            // Filter berdasarkan tahun
            if ($request->filled('min_year')) {
                $query->where('tahun_pembuatan', '>=', $request->min_year);
            }

            if ($request->filled('max_year')) {
                $query->where('tahun_pembuatan', '<=', $request->max_year);
            }

            // Pengurutan
            $sortBy = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');

            switch ($sortBy) {
                case 'price_low':
                    $query->orderBy('harga_jual', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('harga_jual', 'desc');
                    break;
                case 'year_new':
                    $query->orderBy('tahun_pembuatan', 'desc');
                    break;
                case 'year_old':
                    $query->orderBy('tahun_pembuatan', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $kendaraans = $query->paginate(12);

            // Cache categories for better performance
            $categories = cache()->remember('categories_all', 3600, function () {
                return Category::all();
            });

            // Cache computed values for better performance
            $brands = cache()->remember('available_brands', 1800, function () {
                return Kendaraan::where('status', 'tersedia')
                    ->distinct()
                    ->pluck('merek')
                    ->sort();
            });

            // Statistik untuk filter - use cache for expensive calculations
            $priceRange = cache()->remember('price_range_tersedia', 1800, function () {
                return [
                    'min' => Kendaraan::where('status', 'tersedia')->min('harga_jual'),
                    'max' => Kendaraan::where('status', 'tersedia')->max('harga_jual')
                ];
            });

            $yearRange = cache()->remember('year_range_tersedia', 1800, function () {
                return [
                    'min' => Kendaraan::where('status', 'tersedia')->min('tahun_pembuatan'),
                    'max' => Kendaraan::where('status', 'tersedia')->max('tahun_pembuatan')
                ];
            });

            return view('store.index', compact(
                'kendaraans',
                'categories',
                'brands',
                'priceRange',
                'yearRange'
            ));
        } catch (\Exception $e) {
            Log::error("Error saat mengakses halaman store: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat halaman toko.');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Menampilkan detail kendaraan di store dengan ID: ' . $id);
            $kendaraan = Kendaraan::with(['categories', 'dokumen'])
                ->where('status', 'tersedia')
                ->findOrFail($id);

            // Motor yang serupa berdasarkan algoritma scoring
            $relatedMotors = $this->findSimilarMotors($kendaraan);

            return view('store.show', compact('kendaraan', 'relatedMotors'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan detail kendaraan di store: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('store.index')->with('error', 'Kendaraan tidak ditemukan atau sudah tidak tersedia.');
        }
    }

    /**
     * Mencari motor serupa berdasarkan berbagai kriteria dengan sistem scoring
     */
    private function findSimilarMotors($currentKendaraan)
    {
        // Cache key untuk similar motors
        $cacheKey = "similar_motors_{$currentKendaraan->id}";

        return cache()->remember($cacheKey, 1800, function () use ($currentKendaraan) {
            $candidates = Kendaraan::with(['categories'])
                ->select(['id', 'merek', 'model', 'tahun_pembuatan', 'harga_jual', 'photos'])
                ->where('status', 'tersedia')
                ->where('id', '!=', $currentKendaraan->id)
                ->get();

            // Get current category IDs once
            $currentCategoryIds = $currentKendaraan->categories->pluck('id')->toArray();
            $currentCategoryTypes = $currentKendaraan->categories->pluck('type')->unique()->toArray();

            // Hitung score untuk setiap kandidat
            $scoredCandidates = $candidates->map(function ($candidate) use ($currentKendaraan, $currentCategoryIds, $currentCategoryTypes) {
                $score = 0;

                // Score berdasarkan kategori yang sama (bobot tertinggi)
                $candidateCategoryIds = $candidate->categories->pluck('id')->toArray();
                $commonCategories = array_intersect($currentCategoryIds, $candidateCategoryIds);
                $score += count($commonCategories) * 20; // 20 poin per kategori yang sama

                // Score berdasarkan tipe kategori yang sama
                $candidateCategoryTypes = $candidate->categories->pluck('type')->unique()->toArray();
                $commonTypes = array_intersect($currentCategoryTypes, $candidateCategoryTypes);
                $score += count($commonTypes) * 15; // 15 poin per tipe kategori yang sama

                // Score berdasarkan merek yang sama
                if ($candidate->merek === $currentKendaraan->merek) {
                    $score += 25; // 25 poin untuk merek yang sama
                }

                // Score berdasarkan range harga yang mirip (±30%)
                $priceRange = $currentKendaraan->harga_jual * 0.3;
                $priceDiff = abs($candidate->harga_jual - $currentKendaraan->harga_jual);
                if ($priceDiff <= $priceRange) {
                    $score += 20 - (($priceDiff / $priceRange) * 20); // Max 20 poin, berkurang sesuai selisih
                }

                // Score berdasarkan tahun pembuatan yang mirip (±3 tahun)
                $yearDiff = abs($candidate->tahun_pembuatan - $currentKendaraan->tahun_pembuatan);
                if ($yearDiff <= 3) {
                    $score += 15 - ($yearDiff * 5); // Max 15 poin, berkurang 5 per tahun
                }

                // Bonus untuk motor dengan foto
                if ($candidate->photos && count($candidate->photos) > 0) {
                    $score += 5;
                }

                return [
                    'motor' => $candidate,
                    'score' => $score
                ];
            });

            // Filter kandidat dengan score minimal 10 dan urutkan berdasarkan score tertinggi
            return $scoredCandidates
                ->filter(function ($item) {
                    return $item['score'] >= 10; // Minimal score untuk dianggap serupa
                })
                ->sortByDesc('score')
                ->take(4)
                ->pluck('motor');
        });
    }
}
