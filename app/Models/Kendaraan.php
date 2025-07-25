<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraans';

    protected $fillable = [
        'nomor_rangka',
        'nomor_mesin',
        'nomor_polisi',
        'merek',
        'model',
        'tahun_pembuatan',
        'harga_modal',
        'harga_jual',
        'status',
        'photos'
    ];

    protected $casts = [
        'photos' => 'array',
        'harga_modal' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'tahun_pembuatan' => 'integer',
    ];

    // Eloquent Relationships
    public function dokumen()
    {
        return $this->hasMany(DokumenKendaraan::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'kendaraan_category');
    }

    // Query Scopes for better performance
    public function scopeAvailable(Builder $query): void
    {
        $query->where('status', 'tersedia');
    }

    public function scopeSold(Builder $query): void
    {
        $query->where('status', 'terjual');
    }

    public function scopeByBrand(Builder $query, string $brand): void
    {
        $query->where('merek', $brand);
    }

    public function scopeByYear(Builder $query, int $year): void
    {
        $query->where('tahun_pembuatan', $year);
    }

    public function scopePriceRange(Builder $query, ?float $min = null, ?float $max = null): void
    {
        if ($min !== null) {
            $query->where('harga_jual', '>=', $min);
        }
        if ($max !== null) {
            $query->where('harga_jual', '<=', $max);
        }
    }

    public function scopeWithMinimalData(Builder $query): void
    {
        $query->select([
            'id',
            'merek',
            'model',
            'tahun_pembuatan',
            'harga_jual',
            'status',
            'photos',
            'created_at'
        ]);
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where(function ($q) use ($search) {
            $q->where('nomor_rangka', 'like', "%{$search}%")
                ->orWhere('nomor_mesin', 'like', "%{$search}%")
                ->orWhere('nomor_polisi', 'like', "%{$search}%")
                ->orWhere('merek', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%");
        });
    }

    // Computed attributes
    public function getProfit()
    {
        return $this->harga_jual - $this->harga_modal;
    }

    // Optimized static methods
    public static function getTotalProfit()
    {
        return self::where('status', 'terjual')
            ->selectRaw('SUM(harga_jual - harga_modal) as total_profit')
            ->value('total_profit') ?? 0;
    }

    public static function getKendaraanTerjual()
    {
        return self::where('status', 'terjual')->get();
    }

    // Optimized static counts
    public static function getTotalTerjual(): int
    {
        return self::where('status', 'terjual')->count();
    }

    public static function getTotalTersedia(): int
    {
        return self::where('status', 'tersedia')->count();
    }

    /**
     * Dapatkan foto utama (foto pertama) untuk ditampilkan
     */
    public function getMainPhoto()
    {
        if ($this->photos && count($this->photos) > 0) {
            return asset('storage/' . $this->photos[0]);
        }
        return null; // Tidak ada gambar default, biarkan view yang menanganinya
    }

    /**
     * Dapatkan semua foto dengan URL lengkap
     */
    public function getPhotosWithUrls()
    {
        if ($this->photos && count($this->photos) > 0) {
            return array_map(function ($photo) {
                return asset('storage/' . $photo);
            }, $this->photos);
        }
        return [];
    }

    /**
     * Tambahkan foto ke kendaraan
     */
    public function addPhoto($photoPath)
    {
        $photos = $this->photos ?? [];
        $photos[] = $photoPath;
        $this->photos = $photos;
        $this->save();
    }

    /**
     * Hapus foto dari kendaraan
     */
    public function removePhoto($photoPath)
    {
        $photos = $this->photos ?? [];
        $photos = array_filter($photos, function ($photo) use ($photoPath) {
            return $photo !== $photoPath;
        });
        $this->photos = array_values($photos);
        $this->save();
    }
}
