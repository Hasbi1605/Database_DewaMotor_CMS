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
            $query = Kendaraan::where('status', 'tersedia');

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
            $categories = Category::all();

            // Mendapatkan merek-merek yang tersedia
            $brands = Kendaraan::where('status', 'tersedia')
                ->distinct()
                ->pluck('merek')
                ->sort();

            // Statistik untuk filter
            $priceRange = [
                'min' => Kendaraan::where('status', 'tersedia')->min('harga_jual'),
                'max' => Kendaraan::where('status', 'tersedia')->max('harga_jual')
            ];

            $yearRange = [
                'min' => Kendaraan::where('status', 'tersedia')->min('tahun_pembuatan'),
                'max' => Kendaraan::where('status', 'tersedia')->max('tahun_pembuatan')
            ];

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

            // Motor yang serupa berdasarkan merek atau kategori
            $relatedMotors = Kendaraan::where('status', 'tersedia')
                ->where('id', '!=', $id)
                ->where(function ($query) use ($kendaraan) {
                    $query->where('merek', $kendaraan->merek)
                        ->orWhereHas('categories', function ($q) use ($kendaraan) {
                            $q->whereIn('categories.id', $kendaraan->categories->pluck('id'));
                        });
                })
                ->limit(4)
                ->get();

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
}
