<?php

/**
 * Contoh implementasi berbagai format nama file untuk gambar kendaraan
 * Pilih salah satu format sesuai kebutuhan Anda
 */

class KendaraanFileNamingExamples
{
    /**
     * Format 1: SAAT INI - Tanggal dan waktu lengkap
     * Format: kendaraan_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg
     */
    public function currentFormat($photo)
    {
        $uploadDate = date('Y-m-d_H-i-s'); // Format: 2025-08-11_14-30-15
        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();
        return "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
    }

    /**
     * Format 2: Tanggal saja (tanpa waktu)
     * Format: kendaraan_2025-08-11_64f7a2b3c8d1e.jpg
     */
    public function dateOnlyFormat($photo)
    {
        $uploadDate = date('Y-m-d'); // Format: 2025-08-11
        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();
        return "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
    }

    /**
     * Format 3: Format Indonesia
     * Format: kendaraan_11-08-2025_14-30-15_64f7a2b3c8d1e.jpg
     */
    public function indonesianFormat($photo)
    {
        $uploadDate = date('d-m-Y_H-i-s'); // Format: 11-08-2025_14-30-15
        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();
        return "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
    }

    /**
     * Format 4: Format kompakt (tanpa separator)
     * Format: kendaraan_20250811143015_64f7a2b3c8d1e.jpg
     */
    public function compactFormat($photo)
    {
        $uploadDate = date('YmdHis'); // Format: 20250811143015
        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();
        return "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
    }

    /**
     * Format 5: Dengan timestamp Unix
     * Format: kendaraan_2025-08-11_1691757015.jpg
     */
    public function timestampFormat($photo)
    {
        $timestamp = time();
        $uploadDate = date('Y-m-d', $timestamp);
        $extension = $photo->getClientOriginalExtension();
        return "kendaraan_{$uploadDate}_{$timestamp}.{$extension}";
    }

    /**
     * Format 6: Dengan bulan nama (Bahasa Indonesia)
     * Format: kendaraan_11-Agustus-2025_14-30-15_64f7a2b3c8d1e.jpg
     */
    public function indonesianMonthFormat($photo)
    {
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $day = date('d');
        $month = $months[date('m')];
        $year = date('Y');
        $time = date('H-i-s');
        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();

        return "kendaraan_{$day}-{$month}-{$year}_{$time}_{$uniqueId}.{$extension}";
    }

    /**
     * Format 7: Dengan nomor urut harian
     * Format: kendaraan_2025-08-11_001_64f7a2b3c8d1e.jpg
     */
    public function dailySequenceFormat($photo)
    {
        $uploadDate = date('Y-m-d');

        // Hitung jumlah file yang sudah ada hari ini
        $storageDir = storage_path('app/public/kendaraan');
        $existingFiles = glob("{$storageDir}/kendaraan_{$uploadDate}_*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        $sequence = str_pad(count($existingFiles) + 1, 3, '0', STR_PAD_LEFT);

        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();

        return "kendaraan_{$uploadDate}_{$sequence}_{$uniqueId}.{$extension}";
    }
}

/**
 * CARA MENGGUNAKAN:
 * 
 * Untuk mengganti format nama file, edit method optimizeAndSaveImage()
 * di KendaraanController.php, ganti bagian:
 * 
 * // Dari format saat ini:
 * $uploadDate = date('Y-m-d_H-i-s');
 * $uniqueId = uniqid();
 * $extension = $photo->getClientOriginalExtension();
 * $photoName = "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
 * 
 * // Ke format yang diinginkan, misalnya format Indonesia:
 * $uploadDate = date('d-m-Y_H-i-s');
 * $uniqueId = uniqid();
 * $extension = $photo->getClientOriginalExtension();
 * $photoName = "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
 */
