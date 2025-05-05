<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;

class HomeController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        $totalKendaraan = $kendaraans->count();

        return view('home', compact('kendaraans', 'totalKendaraan'));
    }
}
