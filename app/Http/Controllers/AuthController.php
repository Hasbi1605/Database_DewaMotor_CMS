<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke admin
        if ($this->authService->isAuthenticated()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Menangani permintaan login
     */
    public function login(LoginRequest $request)
    {
        try {
            // Get validated data from Form Request
            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            // Attempt login using service
            if ($this->authService->attemptLogin($credentials, $remember)) {
                $request->session()->regenerate();

                $user = $this->authService->getCurrentUser();
                return redirect()
                    ->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, ' . $user->name . '!');
            }

            return back()->withErrors([
                'email' => 'Email atau password tidak sesuai.',
            ])->withInput($request->except('password'));
        } catch (\Exception $e) {
            Log::error("Error saat login: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat login.',
            ])->withInput($request->except('password'));
        }
    }

    /**
     * Menangani permintaan logout
     */
    public function logout(Request $request)
    {
        try {
            // Logout using service
            $this->authService->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('store.index')
                ->with('success', 'Anda telah berhasil logout.');
        } catch (\Exception $e) {
            Log::error("Error saat logout: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()
                ->route('store.index')
                ->with('error', 'Terjadi kesalahan saat logout.');
        }
    }

    /**
     * Menampilkan form registrasi
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Menangani registrasi 
     */
    public function register(RegisterRequest $request)
    {
        try {
            // Get validated data from Form Request
            $validatedData = $request->validated();

            // Validate admin token using service
            if (!$this->authService->validateAdminToken($validatedData['admin_token'])) {
                Log::warning('Token admin tidak valid untuk registrasi: ' . $validatedData['email']);
                return back()->withErrors([
                    'admin_token' => 'Token admin tidak valid. Hubungi administrator untuk mendapatkan token yang benar.',
                ])->withInput($request->except(['password', 'password_confirmation', 'admin_token']));
            }

            // Register admin using service
            $user = $this->authService->registerAdmin($validatedData);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Akun admin berhasil dibuat. Selamat datang!');
        } catch (\Exception $e) {
            Log::error("Error saat registrasi: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat registrasi.',
            ])->withInput($request->except(['password', 'password_confirmation', 'admin_token']));
        }
    }
}
