<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;

class HomeController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all(); // Fetch all kendaraan data
        $totalKendaraan = $kendaraans->count(); // Count total kendaraan
        return view('home', compact('kendaraans', 'totalKendaraan')); // Pass data to the view
    }
}