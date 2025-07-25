<?php

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class KendaraanRepository
{
    protected $model;

    public function __construct(Kendaraan $kendaraan)
    {
        $this->model = $kendaraan;
    }

    /**
     * Get paginated kendaraans with filters and eager loading
     */
    public function getPaginatedWithFilters(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['dokumen', 'categories'])
            ->orderByRaw("CASE WHEN status = 'tersedia' THEN 0 ELSE 1 END")
            ->latest();

        // Apply filters
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_rangka', 'like', "%{$search}%")
                    ->orWhere('nomor_mesin', 'like', "%{$search}%")
                    ->orWhere('nomor_polisi', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category']);
            });
        }

        if (!empty($filters['merek'])) {
            $query->where('merek', $filters['merek']);
        }

        if (!empty($filters['tahun'])) {
            $query->where('tahun_pembuatan', $filters['tahun']);
        }

        if (!empty($filters['harga_min'])) {
            $query->where('harga_jual', '>=', $filters['harga_min']);
        }

        if (!empty($filters['harga_max'])) {
            $query->where('harga_jual', '<=', $filters['harga_max']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get available kendaraans for store with caching
     */
    public function getAvailableForStore(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $cacheKey = 'store_kendaraans_' . md5(serialize($filters)) . '_page_' . request('page', 1);

        return Cache::remember($cacheKey, 900, function () use ($filters, $perPage) {
            $query = $this->model->with(['categories'])
                ->where('status', 'tersedia');

            // Apply store-specific filters
            if (!empty($filters['category'])) {
                $query->whereHas('categories', function ($q) use ($filters) {
                    $q->where('categories.id', $filters['category']);
                });
            }

            if (!empty($filters['brand'])) {
                $query->where('merek', 'like', '%' . $filters['brand'] . '%');
            }

            if (!empty($filters['min_price'])) {
                $query->where('harga_jual', '>=', $filters['min_price']);
            }

            if (!empty($filters['max_price'])) {
                $query->where('harga_jual', '<=', $filters['max_price']);
            }

            if (!empty($filters['min_year'])) {
                $query->where('tahun_pembuatan', '>=', $filters['min_year']);
            }

            if (!empty($filters['max_year'])) {
                $query->where('tahun_pembuatan', '<=', $filters['max_year']);
            }

            // Apply sorting
            $sortBy = $filters['sort'] ?? 'created_at';
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

            return $query->paginate($perPage);
        });
    }

    /**
     * Get kendaraan statistics with caching
     */
    public function getStatistics(): array
    {
        return Cache::remember('kendaraan_statistics', 3600, function () {
            return [
                'total_profit' => $this->model->getTotalProfit(),
                'total_terjual' => $this->model->where('status', 'terjual')->count(),
                'total_tersedia' => $this->model->where('status', 'tersedia')->count(),
                'total_kendaraan' => $this->model->count(),
            ];
        });
    }

    /**
     * Get available brands with caching
     */
    public function getAvailableBrands(): Collection
    {
        return Cache::remember('available_brands', 1800, function () {
            return $this->model->where('status', 'tersedia')
                ->distinct()
                ->pluck('merek')
                ->sort()
                ->values();
        });
    }

    /**
     * Get price range for available kendaraans
     */
    public function getPriceRange(): array
    {
        return Cache::remember('price_range_tersedia', 1800, function () {
            return [
                'min' => $this->model->where('status', 'tersedia')->min('harga_jual'),
                'max' => $this->model->where('status', 'tersedia')->max('harga_jual')
            ];
        });
    }

    /**
     * Get year range for available kendaraans
     */
    public function getYearRange(): array
    {
        return Cache::remember('year_range_tersedia', 1800, function () {
            return [
                'min' => $this->model->where('status', 'tersedia')->min('tahun_pembuatan'),
                'max' => $this->model->where('status', 'tersedia')->max('tahun_pembuatan')
            ];
        });
    }

    /**
     * Find by ID with relationships
     */
    public function findWithRelations(int $id, array $relations = ['dokumen', 'categories']): ?Kendaraan
    {
        return $this->model->with($relations)->find($id);
    }

    /**
     * Find available kendaraan by ID
     */
    public function findAvailableById(int $id): ?Kendaraan
    {
        return $this->model->with(['categories', 'dokumen'])
            ->where('status', 'tersedia')
            ->find($id);
    }
}
