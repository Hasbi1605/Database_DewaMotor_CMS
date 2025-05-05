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
        'status'
    ];

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
}
