<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Attempt to authenticate user
     */
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        Log::info('Percobaan login untuk email: ' . $credentials['email']);

        if (Auth::attempt($credentials, $remember)) {
            Log::info('Login berhasil untuk user: ' . Auth::user()->email);
            return true;
        }

        Log::warning('Login gagal untuk email: ' . $credentials['email']);
        return false;
    }

    /**
     * Register a new admin user
     */
    public function registerAdmin(array $validatedData): User
    {
        Log::info('Percobaan registrasi untuk email: ' . $validatedData['email']);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);
        Log::info('Registrasi berhasil untuk user: ' . $user->email);

        return $user;
    }

    /**
     * Validate admin token
     */
    public function validateAdminToken(string $token): bool
    {
        $validToken = config('app.admin_registration_token');
        return $token === $validToken;
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        $userEmail = Auth::user()->email ?? 'unknown';
        Log::info('User logout: ' . $userEmail);

        Auth::logout();
    }

    /**
     * Check if user is already authenticated
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get current user
     */
    public function getCurrentUser(): ?User
    {
        return Auth::user();
    }
}
