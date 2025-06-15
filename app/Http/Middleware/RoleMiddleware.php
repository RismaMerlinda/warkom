<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Middleware ini digunakan untuk membatasi akses berdasarkan peran (role) pengguna.
     *
     * @param  \Illuminate\Http\Request  $request     Request yang masuk dari client
     * @param  \Closure  $next                      Fungsi berikutnya dalam pipeline middleware
     * @param  mixed  ...$roles                     Daftar role yang diizinkan mengakses route
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil user yang sedang login dari request
        $user = $request->user();

        // Jika tidak ada user yang login atau role-nya tidak termasuk dalam daftar yang diizinkan
        if (! $user || ! in_array($user->role, $roles)) {

            // Redirect ke halaman default berdasarkan role masing-masing
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/transaksi'); // Admin diarahkan ke halaman transaksi
            } elseif ($user->role === 'pelanggan') {
                return redirect()->intended('/pesan'); // Pelanggan diarahkan ke halaman pemesanan
            } elseif ($user->role === 'waiter') {
                return redirect()->intended('/waiter/orders'); // Waiter diarahkan ke daftar pesanan
            } elseif ($user->role === 'kasir') {
                return redirect()->intended('/kasir/orders'); // Kasir diarahkan ke halaman pembayaran
            }

            // Jika tidak memiliki role yang valid, arahkan ke login
            return redirect()->intended('/login');
        }

        // Jika role sesuai, lanjutkan ke proses selanjutnya (akses route)
        return $next($request);
    }
}
