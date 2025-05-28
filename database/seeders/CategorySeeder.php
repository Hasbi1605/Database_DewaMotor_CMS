<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kelas Kendaraan
        $vehicleClasses = [
            ['name' => 'Motor', 'type' => 'class', 'description' => 'Kendaraan roda dua'],
            ['name' => 'Mobil', 'type' => 'class', 'description' => 'Kendaraan roda empat'],
            ['name' => 'Truk', 'type' => 'class', 'description' => 'Kendaraan angkutan berat'],
        ];

        // Merek
        $brands = [
            ['name' => 'Honda', 'type' => 'brand', 'description' => 'Merek Honda'],
            ['name' => 'Yamaha', 'type' => 'brand', 'description' => 'Merek Yamaha'],
            ['name' => 'Suzuki', 'type' => 'brand', 'description' => 'Merek Suzuki'],
            ['name' => 'Toyota', 'type' => 'brand', 'description' => 'Merek Toyota'],
            ['name' => 'Daihatsu', 'type' => 'brand', 'description' => 'Merek Daihatsu'],
        ];

        // Kelengkapan Dokumen
        $documents = [
            ['name' => 'Lengkap', 'type' => 'document', 'description' => 'Semua dokumen lengkap'],
            ['name' => 'Kurang Lengkap', 'type' => 'document', 'description' => 'Sebagian dokumen tidak lengkap'],
            ['name' => 'Tidak Ada', 'type' => 'document', 'description' => 'Dokumen tidak tersedia'],
        ];

        // Kondisi Kendaraan
        $conditions = [
            ['name' => 'Mulus', 'type' => 'condition', 'description' => 'Kondisi sangat baik'],
            ['name' => 'Normal', 'type' => 'condition', 'description' => 'Kondisi normal dengan sedikit perbaikan'],
            ['name' => 'Butuh Perbaikan', 'type' => 'condition', 'description' => 'Memerlukan perbaikan signifikan'],
        ];

        // Insert all categories
        foreach (array_merge($vehicleClasses, $brands, $documents, $conditions) as $category) {
            Category::create($category);
        }
    }
}
