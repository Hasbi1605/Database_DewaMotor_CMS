<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $image = Image::create([
            'title' => $request->title,
            'image_path' => $imagePath,
        ]);

    // Pesan sukses setelah upload
        session()->flash('success', 'Gambar berhasil diunggah');
        return view('upload', ['image' => $image]);
    }

    // Fitur Delete Gambar
    public function delete($id)
    {
        $image = Image::findOrFail($id);

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return redirect()->route('upload.form')->with('deleted', 'Gambar berhasil dihapus!');
    }
}
