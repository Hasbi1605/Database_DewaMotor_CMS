<?php

namespace App\Services;

use App\Models\DokumenKendaraan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DokumenKendaraanService
{
    /**
     * Create a new dokumen kendaraan
     */
    public function createDokumenKendaraan(array $validatedData): DokumenKendaraan
    {
        // Handle file upload
        if (isset($validatedData['file']) && $validatedData['file']) {
            $file = $validatedData['file'];
            $path = $file->store('dokumen-kendaraan', 'public');
            $validatedData['file_path'] = $path;
        }

        // Remove file from data as it's not a database field
        unset($validatedData['file']);

        return DokumenKendaraan::create($validatedData);
    }

    /**
     * Update an existing dokumen kendaraan
     */
    public function updateDokumenKendaraan(array $validatedData, DokumenKendaraan $dokumenKendaraan): DokumenKendaraan
    {
        // Handle file upload
        if (isset($validatedData['file']) && $validatedData['file']) {
            // Delete old file if exists
            $this->deleteFileIfExists($dokumenKendaraan->file_path);

            $file = $validatedData['file'];
            $path = $file->store('dokumen-kendaraan', 'public');
            $validatedData['file_path'] = $path;
        }

        // Remove file from data as it's not a database field
        unset($validatedData['file']);

        $dokumenKendaraan->update($validatedData);

        return $dokumenKendaraan;
    }

    /**
     * Delete dokumen kendaraan
     */
    public function deleteDokumenKendaraan(DokumenKendaraan $dokumenKendaraan): bool
    {
        // Delete file if exists
        $this->deleteFileIfExists($dokumenKendaraan->file_path);

        return $dokumenKendaraan->delete();
    }

    /**
     * Remove file from dokumen kendaraan
     */
    public function removeFile(DokumenKendaraan $dokumenKendaraan): bool
    {
        // Delete file if exists
        if ($this->deleteFileIfExists($dokumenKendaraan->file_path)) {
            $dokumenKendaraan->update(['file_path' => null]);
            return true;
        }

        return false;
    }

    /**
     * Delete file from storage if exists
     */
    private function deleteFileIfExists(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return true;
        }
        return false;
    }
}
