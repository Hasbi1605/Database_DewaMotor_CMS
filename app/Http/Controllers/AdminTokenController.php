<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class AdminTokenController extends Controller
{
    /**
     * Menampilkan informasi token admin
     */
    public function showTokenInfo()
    {
        return view('admin.token-info');
    }

    /**
     * Generate token admin baru
     */
    public function generateNewToken(Request $request)
    {
        try {
            // Generate token baru dengan format yang aman
            $newToken = 'DEWA' . strtoupper(Str::random(8)) . date('Y');

            // Path ke file .env
            $envPath = base_path('.env');

            if (!file_exists($envPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File .env tidak ditemukan'
                ], 500);
            }

            // Baca file .env
            $envContent = file_get_contents($envPath);

            // Update atau tambahkan ADMIN_REGISTRATION_TOKEN
            if (strpos($envContent, 'ADMIN_REGISTRATION_TOKEN=') !== false) {
                // Update token yang sudah ada
                $envContent = preg_replace(
                    '/ADMIN_REGISTRATION_TOKEN=.*/',
                    'ADMIN_REGISTRATION_TOKEN=' . $newToken,
                    $envContent
                );
            } else {
                // Tambahkan token baru jika belum ada
                $envContent .= "\nADMIN_REGISTRATION_TOKEN=" . $newToken;
            }

            // Tulis kembali ke file .env
            file_put_contents($envPath, $envContent);

            // Clear config cache agar perubahan langsung berlaku
            Artisan::call('config:clear');

            // Log aktivitas generate token baru
            Log::info('Token admin baru di-generate', [
                'old_token' => config('app.admin_registration_token'),
                'new_token' => $newToken,
                'user' => auth()->user()->email ?? 'unknown'
            ]);

            return response()->json([
                'success' => true,
                'new_token' => $newToken,
                'message' => 'Token baru berhasil di-generate'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat generate token baru: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat generate token baru'
            ], 500);
        }
    }
}
