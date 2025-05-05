<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;

class HomeController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        $totalKendaraan = $kendaraans->count();
        $kendaraanTerjual = Kendaraan::where('status', 'terjual')->get();
        $totalTerjual = $kendaraanTerjual->count();
        $totalProfit = Kendaraan::getTotalProfit();

        return view('home', compact('kendaraans', 'totalKendaraan', 'totalTerjual', 'totalProfit', 'kendaraanTerjual'));
    }
}
