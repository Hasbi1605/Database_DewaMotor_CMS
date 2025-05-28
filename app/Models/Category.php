<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description'
    ];

    const TYPE_CLASS = 'class';
    const TYPE_BRAND = 'brand';
    const TYPE_DOCUMENT = 'document';
    const TYPE_CONDITION = 'condition';

    public function kendaraans()
    {
        return $this->belongsToMany(Kendaraan::class, 'kendaraan_category');
    }

    // Helper method to get categories by type
    public static function getByType($type)
    {
        return self::where('type', $type)->get();
    }
}
