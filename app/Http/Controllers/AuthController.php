<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Coba login
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Redirect ke dashboard
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::user()->nama . '!');
        }

        // Jika login gagal
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout');
    }

    // Method untuk membuat user admin pertama (untuk testing)
    public function createAdmin()
    {
        // Cek apakah sudah ada user
        if (User::count() > 0) {
            return redirect()->route('login')
                ->with('error', 'Admin sudah ada');
        }

        // Buat user admin
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('admin123'),
        ]);

        return redirect()->route('login')
            ->with('success', 'Admin berhasil dibuat. Email: admin@laundry.com, Password: admin123');
    }
}
