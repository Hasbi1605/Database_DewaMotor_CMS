<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Menampilkan daftar resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getCategoriesGroupedByType();
        return view('paneladmin.kelola-kategori.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        $types = $this->categoryService->getAvailableTypes();
        return view('paneladmin.kelola-kategori.create', compact('types'));
    }

    /**
     * Menyimpan resource yang baru dibuat ke storage.
     */
    public function store(CategoryRequest $request)
    {
        // Get validated data from Form Request
        $validatedData = $request->validated();

        // Create category using service
        $this->categoryService->createCategory($validatedData);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Menampilkan resource yang spesifik.
     */
    public function show(string $id)
    {
        try {
            Log::info('Menampilkan kategori dengan ID: ' . $id);
            $category = Category::findOrFail($id);
            return view('paneladmin.kelola-kategori.show', compact('category'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan kategori: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
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
            Log::info('Menampilkan form edit untuk kategori dengan ID: ' . $id);
            $category = Category::findOrFail($id);
            $types = $this->categoryService->getAvailableTypes();
            return view('paneladmin.kelola-kategori.edit', compact('category', 'types'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menampilkan form edit: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan');
        }
    }

    /**
     * Memperbarui resource yang spesifik di storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try {
            Log::info('Memperbarui kategori dengan ID: ' . $id);
            $category = Category::findOrFail($id);

            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Update category using service
            $this->categoryService->updateCategory($validatedData, $category);

            return redirect()->route('categories.index')
                ->with('success', 'Kategori berhasil diperbarui');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error memperbarui kategori: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
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
            Log::info('Menghapus kategori dengan ID: ' . $id);
            $category = Category::findOrFail($id);

            // Delete category using service
            $this->categoryService->deleteCategory($category);

            return redirect()->route('categories.index')
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Error menghapus kategori: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak ditemukan');
        }
    }
}
