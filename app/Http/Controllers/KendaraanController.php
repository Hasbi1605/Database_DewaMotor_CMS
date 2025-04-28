<?php  

namespace App\Http\Controllers;  

use App\Models\Kendaraan;  
use Illuminate\Http\Request;  

class KendaraanController extends Controller  
{  
    public function index()  
    {  
        $kendaraans = Kendaraan::all(); // Mengambil semua data kendaraan dari database  
        return view('kendaraans.index', compact('kendaraans')); // Mengirim data ke view  
    }  

    public function create()  
    {  
        return view('kendaraans.create');  
    }  

    public function store(Request $request)  
    {  
        // Validasi data yang diterima  
        $validatedData = $request->validate([  
            'nomor_rangka' => 'required|string|max:255',  
            'nomor_mesin' => 'required|string|max:255',  
            'nomor_polisi' => 'required|string|max:255',  
            'merek' => 'required|string|max:255',  
            'model' => 'required|string|max:255',  
            'tahun_pembuatan' => 'required|integer',  
            'harga_modal' => 'required|numeric',  
            'harga_jual' => 'required|numeric',  
        ]);  
    
        // Simpan data kendaraan ke database  
        Kendaraan::create($validatedData);  
    
        // Redirect ke halaman daftar dengan pesan sukses  
        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan.');  
    }  
    public function show($id)  
    {  
        $kendaraan = Kendaraan::find($id);  
        if (!$kendaraan) {  
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');  
        }  
        return view('kendaraans.show', compact('kendaraan'));  
    }  

    public function edit($id)  
    {  
        $kendaraan = Kendaraan::find($id);  
        if (!$kendaraan) {  
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');  
        }  
        return view('kendaraans.edit', compact('kendaraan'));  
    }  

    public function update(Request $request, $id)  
    {  
        $validatedData = $request->validate([  
            'nomor_rangka' => 'required|string|max:255',  
            'nomor_mesin' => 'required|string|max:255',  
            'nomor_polisi' => 'required|string|max:255',  
            'merek' => 'required|string|max:255',  
            'model' => 'required|string|max:255',  
            'tahun_pembuatan' => 'required|integer',  
            'harga_modal' => 'required|numeric',  
            'harga_jual' => 'required|numeric',  
        ]);  

        $kendaraan = Kendaraan::find($id);  
        if (!$kendaraan) {  
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');  
        }  

        $kendaraan->update($validatedData);  

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil diperbarui.');  
    }  

    public function destroy($id)  
    {  
        $kendaraan = Kendaraan::find($id);  
        if (!$kendaraan) {  
            return redirect()->route('kendaraans.index')->with('error', 'Kendaraan tidak ditemukan.');  
        }  

        $kendaraan->delete();  

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil dihapus.');  
    }  
}