<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\WaiterController;
use Illuminate\Support\Facades\Route;

// ===== AUTH ROUTE (Login & Register) =====

// Menampilkan form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Menangani proses login (POST)
Route::post('/login', [AuthController::class, 'loginWeb']);

// Menampilkan form registrasi
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Menangani proses registrasi (POST)
Route::post('/register', [AuthController::class, 'registerWeb']);

// Jika user mengakses root URL, arahkan ke halaman login
Route::get('/', function () {
    return view('auth.login');
});

// ===== ROUTE YANG MEMBUTUHKAN AUTHENTIKASI =====
Route::middleware('auth')->group(function () {

    // Logout route
    Route::post('/logout', [AuthController::class, 'logoutWeb'])->name('logout');

    // ===== ADMIN ROUTES =====
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            // Halaman daftar transaksi
            Route::get('/transaksi', [AdminController::class, 'indexTransaksi'])->name('transaksi');

            // Manajemen kasir
            Route::get('/kasir', [AdminController::class, 'indexKasir'])->name('kasir.index');
            Route::get('/kasir/create', [AdminController::class, 'createKasir'])->name('kasir.create');
            Route::post('/kasir', [AdminController::class, 'storeKasir'])->name('kasir.store');
            Route::delete('/kasir/{id}', [AdminController::class, 'destroyKasir'])->name('kasir.destroy');

            // Manajemen waiter
            Route::get('/waiter', [AdminController::class, 'indexWaiter'])->name('waiter.index');
            Route::get('/waiter/create', [AdminController::class, 'createWaiter'])->name('waiter.create');
            Route::post('/waiter', [AdminController::class, 'storeWaiter'])->name('waiter.store');
            Route::delete('/waiter/{id}', [AdminController::class, 'destroyWaiter'])->name('waiter.destroy');

            // Melihat daftar pelanggan
            Route::get('/pelanggan', [AdminController::class, 'indexPelanggan'])->name('pelanggan.index');
        });
    });

    // ===== PELANGGAN ROUTES =====
    Route::middleware('role:pelanggan')->group(function () {
        // Melihat daftar pesanan sendiri
        Route::get('/pesanan', [PelangganController::class, 'index'])->name('pesanan.index');
        // Menampilkan form pemesanan
        Route::get('/pesan', [PelangganController::class, 'create'])->name('pesanan.create');
        // Menyimpan pesanan baru
        Route::post('/pesan', [PelangganController::class, 'store'])->name('pesanan.store');
    });

    // ===== WAITER ROUTES =====
    Route::middleware('role:waiter')->group(function () {
        // Melihat daftar semua pesanan dari pelanggan
        Route::get('/waiter/orders', [WaiterController::class, 'listOrders'])->name('waiter.list-orders');
        // Menampilkan form untuk mencatat pesanan pelanggan
        Route::get('/waiter/orders/create', [WaiterController::class, 'showCreateOrder'])->name('waiter.show-create-order');
        // Menyimpan pesanan baru dari waiter
        Route::post('/waiter/orders', [WaiterController::class, 'createOrder'])->name('waiter.create-order');
        // Update status pesanan (misal: selesai disajikan)
        Route::patch('/waiter/orders/{orderId}/status', [WaiterController::class, 'updateStatus'])->name('waiter.update-status');
    });

    // ===== KASIR ROUTES =====
    Route::middleware('role:kasir')->group(function () {
        // Menampilkan semua pesanan yang perlu dibayar
        Route::get('/kasir/orders', [KasirController::class, 'index'])->name('kasir.list-orders');
        // Memproses pembayaran untuk pesanan tertentu
        Route::patch('/kasir/orders/{id}/pembayaran', [KasirController::class, 'prosesPembayaran'])->name('kasir.proses-pembayaran');
    });
});
