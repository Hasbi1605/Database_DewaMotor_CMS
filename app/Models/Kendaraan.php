<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'photos' => 'array'
    ];

    public function dokumen()
    {
        return $this->hasMany(DokumenKendaraan::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'kendaraan_category');
    }

    public function getProfit()
    {
        return $this->harga_jual - $this->harga_modal;
    }

    public static function getTotalProfit()
    {
        return self::where('status', 'terjual')
            ->get()
            ->sum(function ($kendaraan) {
                return $kendaraan->getProfit();
            });
    }

    public static function getKendaraanTerjual()
    {
        return self::where('status', 'terjual')->get();
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
