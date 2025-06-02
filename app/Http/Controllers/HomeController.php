<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::query();

        // Apply category filter if selected
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Mengurutkan kendaraan berdasarkan ID dari terbesar ke terkecil
        $query->orderBy('id', 'desc');

        $kendaraans = $query->get();
        $totalKendaraan = Kendaraan::count(); // mengambil total kendaraan
        $kendaraanTerjual = Kendaraan::where('status', 'terjual')->get();
        $totalTerjual = $kendaraanTerjual->count();
        $totalProfit = Kendaraan::getTotalProfit();
        $categories = Category::all();

        return view('home', compact('kendaraans', 'totalKendaraan', 'totalTerjual', 'totalProfit', 'kendaraanTerjual', 'categories'));
    }
}
