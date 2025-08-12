<?php

/**
 * Contoh implementasi penamaan file berdasarkan model motor
 * File ini menunjukkan bagaimana sistem membersihkan dan memformat nama file
 */

class MotorFileNamingExamples
{
    /**
     * Contoh pembersihan nama untuk berbagai merek dan model
     */
    public function getCleaningExamples()
    {
        return [
            // Format: [input] => [output]
            'Merek Examples' => [
                'Honda' => 'honda',
                'YAMAHA' => 'yamaha',
                'Suzuki Motor' => 'suzuki_motor',
                'Kawasaki Indonesia' => 'kawasaki_indonesia',
                'TVS Motor' => 'tvs_motor',
                'Benelli & Co' => 'benelli_co',
                'KTM-Austria' => 'ktm_austria',
            ],

            'Model Examples' => [
                'Beat' => 'beat',
                'Beat Street' => 'beat_street',
                'Vario 125' => 'vario_125',
                'Vario 150 eSP' => 'vario_150_esp',
                'MIO S' => 'mio_s',
                'MIO M3 125' => 'mio_m3_125',
                'NMAX 155' => 'nmax_155',
                'NMAX Connected' => 'nmax_connected',
                'NEX II' => 'nex_ii',
                'Satria F150' => 'satria_f150',
                'GSX-R150' => 'gsx_r150',
                'Ninja 250' => 'ninja_250',
                'Ninja ZX-25R' => 'ninja_zx_25r',
                'Z900 ABS' => 'z900_abs',
            ]
        ];
    }

    /**
     * Contoh nama file yang akan dihasilkan
     */
    public function getFileNamingExamples()
    {
        $examples = [
            [
                'merek' => 'Honda',
                'model' => 'Beat Street',
                'timestamp' => '2025-08-11_14-30-15',
                'result' => 'honda_beat_street_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg'
            ],
            [
                'merek' => 'YAMAHA',
                'model' => 'NMAX 155',
                'timestamp' => '2025-08-11_16-45-22',
                'result' => 'yamaha_nmax_155_2025-08-11_16-45-22_64f7a2b3c8d1f.png'
            ],
            [
                'merek' => 'Suzuki',
                'model' => 'GSX-R150',
                'timestamp' => '2025-08-11_09-15-30',
                'result' => 'suzuki_gsx_r150_2025-08-11_09-15-30_64f7a2b3c8d1g.jpg'
            ],
            [
                'merek' => 'Kawasaki',
                'model' => 'Ninja ZX-25R',
                'timestamp' => '2025-08-11_11-20-45',
                'result' => 'kawasaki_ninja_zx_25r_2025-08-11_11-20-45_64f7a2b3c8d1h.jpg'
            ],
            [
                'merek' => 'TVS Motor',
                'model' => 'Apache RTR 160',
                'timestamp' => '2025-08-11_13-35-10',
                'result' => 'tvs_motor_apache_rtr_160_2025-08-11_13-35-10_64f7a2b3c8d1i.png'
            ]
        ];

        return $examples;
    }

    /**
     * Simulasi fungsi cleanFileName seperti di controller
     */
    public function cleanFileName($string)
    {
        if (empty($string)) {
            return null;
        }

        // Ubah ke lowercase dan ganti spasi dengan underscore
        $cleaned = strtolower($string);

        // Ganti karakter yang tidak diizinkan dengan underscore
        $cleaned = preg_replace('/[^a-z0-9\-_]/', '_', $cleaned);

        // Hilangkan underscore berturut-turut
        $cleaned = preg_replace('/_+/', '_', $cleaned);

        // Hilangkan underscore di awal dan akhir
        $cleaned = trim($cleaned, '_');

        return $cleaned;
    }

    /**
     * Contoh penggunaan dalam berbagai skenario
     */
    public function getUseCaseExamples()
    {
        return [
            'Pencarian File' => [
                'Semua Honda' => 'honda_*',
                'Semua Beat' => '*_beat_*',
                'Honda Beat saja' => 'honda_beat_*',
                'Upload hari ini' => '*_2025-08-11_*',
                'Yamaha NMAX hari ini' => 'yamaha_nmax_*_2025-08-11_*'
            ],

            'Organisasi Folder' => [
                'Bisa dikelompokkan berdasarkan merek',
                'Bisa dikelompokkan berdasarkan model',
                'Mudah untuk backup per kategori',
                'Otomatis terurut alphabetically'
            ],

            'Manajemen Inventory' => [
                'Quick count per model',
                'Visual identification',
                'Easy cataloging',
                'Efficient storage management'
            ]
        ];
    }

    /**
     * Contoh edge cases dan penanganannya
     */
    public function getEdgeCases()
    {
        return [
            'Input kosong' => [
                'merek' => '',
                'model' => '',
                'result' => 'kendaraan_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg'
            ],

            'Karakter khusus' => [
                'merek' => 'Honda & Yamaha Co.',
                'model' => 'Beat (Special Edition)',
                'cleaned_merek' => 'honda_yamaha_co',
                'cleaned_model' => 'beat_special_edition',
                'result' => 'honda_yamaha_co_beat_special_edition_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg'
            ],

            'Nama sangat panjang' => [
                'merek' => 'Very Long Brand Name With Many Words',
                'model' => 'Super Long Model Name With Specifications And Details',
                'cleaned_merek' => 'very_long_brand_name_with_many_words',
                'cleaned_model' => 'super_long_model_name_with_specifications_and_details',
                'result' => 'very_long_brand_name_with_many_words_super_long_model_name_with_specifications_and_details_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg'
            ]
        ];
    }
}

/**
 * CARA TESTING:
 * 
 * 1. Upload foto motor Honda Beat
 *    Input: merek="Honda", model="Beat Street"
 *    Expected: honda_beat_street_2025-08-11_XX-XX-XX_XXXXX.jpg
 * 
 * 2. Upload foto motor Yamaha NMAX
 *    Input: merek="YAMAHA", model="NMAX 155"
 *    Expected: yamaha_nmax_155_2025-08-11_XX-XX-XX_XXXXX.jpg
 * 
 * 3. Upload tanpa data lengkap
 *    Input: merek="", model=""
 *    Expected: kendaraan_2025-08-11_XX-XX-XX_XXXXX.jpg (fallback)
 */
