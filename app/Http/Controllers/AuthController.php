<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke admin
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Menangani permintaan login
     */
    public function login(Request $request)
    {
        try {
            Log::info('Percobaan login untuk email: ' . $request->email);
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ], [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
            ]);

            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                Log::info('Login berhasil untuk user: ' . Auth::user()->email);

                return redirect()
                    ->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
            }

            Log::warning('Login gagal untuk email: ' . $request->email);
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
            $userEmail = Auth::user()->email ?? 'unknown';
            Log::info('User logout: ' . $userEmail);

            Auth::logout();

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
    public function register(Request $request)
    {
        try {
            Log::info('Percobaan registrasi untuk email: ' . $request->email);
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            Log::info('Registrasi berhasil untuk user: ' . $user->email);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Akun berhasil dibuat. Selamat datang!');
        } catch (\Exception $e) {
            Log::error("Error saat registrasi: " . $e->getMessage(), [
                'request' => request()->all(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat registrasi.',
            ])->withInput($request->except('password'));
        }
    }
}
