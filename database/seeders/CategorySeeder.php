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
            ['name' => 'Kelas Atas', 'type' => 'class', 'description' => 'Range Harga 60 Juta ke Atas'],
            ['name' => 'Kelas Menengah', 'type' => 'class', 'description' => 'Range Harga 30 Juta - 60 Juta'],
            ['name' => 'Kelas Bawah', 'type' => 'class', 'description' => 'Range Harga di Bawah 30 Juta'],
        ];

        // Merek
        $brands = [
            ['name' => 'Honda', 'type' => 'brand', 'description' => 'Merek Honda'],
            ['name' => 'Yamaha', 'type' => 'brand', 'description' => 'Merek Yamaha'],
            ['name' => 'Suzuki', 'type' => 'brand', 'description' => 'Merek Suzuki'],
            ['name' => 'Vespa', 'type' => 'brand', 'description' => 'Merek Vespa'],
            ['name' => 'Kawasaki', 'type' => 'brand', 'description' => 'Merek Kawasaki'],
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
            ['name' => 'Normal', 'type' => 'condition', 'description' => 'Kondisi normal dengan'],
            ['name' => 'Butuh Perbaikan', 'type' => 'condition', 'description' => 'Memerlukan perbaikan'],
        ];

        // Insert all categories
        foreach (array_merge($vehicleClasses, $brands, $documents, $conditions) as $category) {
            Category::create($category);
        }
    }
}
