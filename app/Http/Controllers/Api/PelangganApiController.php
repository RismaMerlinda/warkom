<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PelangganApiController extends Controller
{
    // Menampilkan daftar pesanan milik user (pelanggan) yang sedang login
    public function index()
    {
        // Ambil semua data pesanan berdasarkan ID user yang sedang login (autentikasi via API)
        $orders = Order::where('user_id', auth()->id())->get();

        // Kembalikan data pesanan dalam format JSON
        return response()->json($orders);
    }

    // Menyimpan pesanan baru yang dikirim oleh pelanggan melalui API
    public function store(Request $request)
    {
        // Buat pesanan baru menggunakan data dari request dan ID user yang sedang login
        $order = Order::create([
            'user_id' => auth()->id(),         // ID user login sebagai pelanggan
            'menu_id' => $request->menu_id,    // ID menu yang dipilih
            'jumlah' => $request->jumlah,      // Jumlah yang dipesan
            'status' => 'baru',                // Status awal pesanan adalah 'baru'
        ]);

        // Kembalikan response dalam bentuk JSON dengan kode status 201 (Created)
        return response()->json($order, 201);
    }
}
