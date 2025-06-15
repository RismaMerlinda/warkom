<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login'); // Mengarahkan ke tampilan login
    }

    // Proses autentikasi login pengguna dari web
    public function loginWeb(Request $request)
    {
        // Validasi input username dan password
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba melakukan login dengan kombinasi username dan password
        if (Auth::attempt($request->only('username', 'password'))) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect berdasarkan role user yang login
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/transaksi'); // Admin diarahkan ke halaman transaksi
            } elseif (Auth::user()->role === 'pelanggan') {
                return redirect()->intended('/pesan'); // Pelanggan diarahkan ke halaman pemesanan
            } elseif (Auth::user()->role === 'waiter') {
                return redirect()->intended('/waiter/orders'); // Waiter diarahkan ke daftar pesanan
            } elseif (Auth::user()->role === 'kasir') {
                return redirect()->intended('/kasir/orders'); // Kasir diarahkan ke halaman pembayaran
            }

            // Jika role tidak dikenali, arahkan kembali ke login
            return redirect()->intended('/login');
        }

        // Jika login gagal, kirim pesan error ke form login
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Menampilkan halaman form registrasi
    public function showRegisterForm()
    {
        return view('auth.register'); // Mengarahkan ke tampilan register
    }

    // Proses registrasi user baru dari web
    public function registerWeb(Request $request)
    {
        // Validasi data input untuk registrasi
        $request->validate([
            'nama_user' => 'required|string|max:100', // Nama wajib diisi dan maksimal 100 karakter
            'username' => 'required|string|max:50|unique:tb_user,username', // Username unik dan maksimal 50 karakter
            'password' => 'required|string|min:6|confirmed', // Password minimal 6 karakter dan harus dikonfirmasi
        ]);

        // Simpan user baru ke dalam database dengan role default 'pelanggan'
        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password sebelum disimpan
            'role' => 'pelanggan', // Role default untuk user baru adalah pelanggan
        ]);

        // Arahkan ke halaman login setelah berhasil registrasi
        return redirect()->route('login')->with('success', 'Berhasil mendaftar! Silakan login.');
    }

    // Proses logout user dari aplikasi
    public function logoutWeb(Request $request)
    {
        Auth::logout(); // Logout user yang sedang login
        $request->session()->invalidate(); // Hapus session yang sedang aktif
        $request->session()->regenerateToken(); // Regenerasi CSRF token untuk keamanan

        return redirect()->route('login'); // Arahkan ke halaman login
    }
}
