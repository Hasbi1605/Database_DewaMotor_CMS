<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar resource.
     */
    public function index()
    {
        $categories = [
            'class' => Category::getByType('class'),
            'brand' => Category::getByType('brand'),
            'document' => Category::getByType('document'),
            'condition' => Category::getByType('condition')
        ];

        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        $types = ['class', 'brand', 'document', 'condition'];
        return view('categories.create', compact('types'));
    }

    /**
     * Menyimpan resource yang baru dibuat ke storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:class,brand,document,condition',
            'description' => 'nullable|string'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Menampilkan resource yang spesifik.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('categories.show', compact('category'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan');
        }
    }

    /**
     * Menampilkan form untuk edit resource yang spesifik.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $types = ['class', 'brand', 'document', 'condition'];
            return view('categories.edit', compact('category', 'types'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan');
        }
    }

    /**
     * Memperbarui resource yang spesifik di storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|in:class,brand,document,condition',
                'description' => 'nullable|string'
            ]);

            $category->update($validated);

            return redirect()->route('categories.index')
                ->with('success', 'Kategori berhasil diperbarui');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan');
        }
    }

    /**
     * Menghapus resource yang spesifik dari storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.index')
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan');
        }
    }
}
