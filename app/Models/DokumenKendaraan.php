<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kendaraan_id',
        'jenis_dokumen',
        'nomor_dokumen',
        'tanggal_terbit',
        'tanggal_expired',
        'file_path',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
