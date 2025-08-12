<?php

namespace App\Services;

use App\Models\Kendaraan;
use App\Repositories\KendaraanRepository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class KendaraanService
{
    protected $kendaraanRepository;

    public function __construct(KendaraanRepository $kendaraanRepository)
    {
        $this->kendaraanRepository = $kendaraanRepository;
    }

    /**
     * Create a new kendaraan
     */
    public function createKendaraan(array $validatedData): Kendaraan
    {
        // Handle photo uploads
        $photoPaths = [];
        if (isset($validatedData['photos']) && is_array($validatedData['photos'])) {
            foreach ($validatedData['photos'] as $photo) {
                $photoPaths[] = $this->optimizeAndSaveImage($photo, $validatedData['merek'], $validatedData['model']);
            }
        }

        // Store category data for later use
        $categoryData = [
            'class_category' => $validatedData['class_category'] ?? null,
            'brand_category' => $validatedData['brand_category'] ?? null,
            'document_category' => $validatedData['document_category'] ?? null,
            'condition_category' => $validatedData['condition_category'] ?? null,
        ];

        // Remove category fields and photos from validated data
        unset($validatedData['photos'], $validatedData['class_category'], $validatedData['brand_category'], $validatedData['document_category'], $validatedData['condition_category']);

        // Add processed photo paths
        $validatedData['photos'] = $photoPaths;

        // Create kendaraan using repository
        $kendaraan = Kendaraan::create($validatedData);

        // Sync categories
        $this->syncCategories($kendaraan, $categoryData);

        return $kendaraan;
    }

    /**
     * Update an existing kendaraan
     */
    public function updateKendaraan(array $validatedData, Kendaraan $kendaraan): Kendaraan
    {
        // Handle photo uploads
        $photoPaths = $kendaraan->photos ?? [];
        if (isset($validatedData['photos']) && is_array($validatedData['photos'])) {
            foreach ($validatedData['photos'] as $photo) {
                $photoPaths[] = $this->optimizeAndSaveImage($photo, $validatedData['merek'], $validatedData['model']);
            }
        }

        // Store category data for later use
        $categoryData = [
            'class_category' => $validatedData['class_category'] ?? null,
            'brand_category' => $validatedData['brand_category'] ?? null,
            'document_category' => $validatedData['document_category'] ?? null,
            'condition_category' => $validatedData['condition_category'] ?? null,
        ];

        // Remove category fields and photos from validated data
        unset($validatedData['photos'], $validatedData['class_category'], $validatedData['brand_category'], $validatedData['document_category'], $validatedData['condition_category']);

        // Add processed photo paths
        $validatedData['photos'] = $photoPaths;

        // Update kendaraan
        $kendaraan->update($validatedData);

        // Sync categories
        $this->syncCategories($kendaraan, $categoryData);

        return $kendaraan;
    }

    /**
     * Sync categories for kendaraan
     */
    private function syncCategories(Kendaraan $kendaraan, array $categoryData): void
    {
        // Collect category IDs from individual fields
        $categoryIds = array_filter([
            $categoryData['class_category'] ?? null,
            $categoryData['brand_category'] ?? null,
            $categoryData['document_category'] ?? null,
            $categoryData['condition_category'] ?? null
        ]);

        // Sync categories if any are selected
        if (!empty($categoryIds)) {
            $kendaraan->categories()->sync($categoryIds);
        }
    }

    /**
     * Optimize and save image
     */
    private function optimizeAndSaveImage($photo, $merek = null, $model = null): string
    {
        // Create Image Manager instance
        $manager = new ImageManager(new Driver());

        // Ensure storage directory exists
        $storageDir = storage_path('app/public/kendaraan');
        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        // Clean brand and model names for filename
        $cleanMerek = $this->cleanFileName($merek);
        $cleanModel = $this->cleanFileName($model);

        // Generate filename with motor model
        $uploadDate = date('Y-m-d_H-i-s'); // Format: 2025-08-11_14-30-15
        $uniqueId = uniqid();
        $extension = $photo->getClientOriginalExtension();

        // Format: {merek}_{model}_{date}_{unique_id}.{extension}
        if ($cleanMerek && $cleanModel) {
            $photoName = "{$cleanMerek}_{$cleanModel}_{$uploadDate}_{$uniqueId}.{$extension}";
        } else {
            // Fallback to old format if data is incomplete
            $photoName = "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
        }

        // Read uploaded image and optimize
        $image = $manager->read($photo->getRealPath());

        // Resize image to maximum width of 1200 pixels while maintaining aspect ratio
        $image->scale(width: 1200);

        // Save optimized image with 75% quality
        $image->save(storage_path('app/public/kendaraan/' . $photoName), 75);

        // Return relative path for database
        return 'kendaraan/' . $photoName;
    }

    /**
     * Clean filename to be safe for filesystem
     */
    private function cleanFileName($string): ?string
    {
        if (empty($string)) {
            return null;
        }

        // Convert to lowercase and replace spaces with underscores
        $cleaned = strtolower($string);

        // Replace disallowed characters with underscores
        $cleaned = preg_replace('/[^a-z0-9\-_]/', '_', $cleaned);

        // Remove consecutive underscores
        $cleaned = preg_replace('/_+/', '_', $cleaned);

        // Remove underscores at the beginning and end
        $cleaned = trim($cleaned, '_');

        return $cleaned;
    }

    /**
     * Remove photo from kendaraan
     */
    public function removePhoto(Kendaraan $kendaraan, string $photoPath): bool
    {
        // Remove from storage
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        // Remove from database
        $kendaraan->removePhoto($photoPath);
        return true;
    }

    /**
     * Update kendaraan status
     */
    public function updateStatus(Kendaraan $kendaraan, string $status): bool
    {
        $kendaraan->status = $status;
        return $kendaraan->save();
    }
}
