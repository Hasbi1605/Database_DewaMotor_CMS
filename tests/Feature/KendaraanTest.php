<?php

namespace Tests\Feature;

use App\Models\Kendaraan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KendaraanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_kendaraan()
    {
        Kendaraan::factory()->count(3)->create();

        $response = $this->get('/kendaraans');

        $response->assertStatus(200);
        $response->assertViewIs('kendaraans.index');
        $response->assertViewHas('kendaraans');
    }

    public function test_can_create_kendaraan()
    {
        $kendaraanData = [
            'nomor_rangka' => 'TEST123',
            'nomor_mesin' => 'MESIN123',
            'nomor_polisi' => 'B 1234 TEST',
            'merek' => 'Honda',
            'model' => 'CBR',
            'tahun_pembuatan' => 2023,
            'harga_modal' => 25000000,
            'harga_jual' => 27000000
        ];

        $response = $this->post('/kendaraans', $kendaraanData);

        $response->assertRedirect('/kendaraans');
        $this->assertDatabaseHas('KENDARAAN', [
            'NOMOR_RANGKA' => 'TEST123'
        ]);
    }
}
