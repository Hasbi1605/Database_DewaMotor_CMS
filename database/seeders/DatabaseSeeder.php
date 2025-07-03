<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class, // Seed admin user first
            KendaraanSeeder::class, // Seed kendaraan
            CategorySeeder::class,
            DokumenKendaraanSeeder::class
        ]);
    }
}
