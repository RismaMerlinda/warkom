<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    // Menampilkan daftar pesanan milik pelanggan yang sedang login
    public function index()
    {
        $orders = Order::where('pelanggan_id', auth()->id()) // Ambil pesanan berdasarkan ID pelanggan yang sedang login
            ->with(['items.menu', 'pelanggan']) // Sertakan relasi items (detail pesanan) dan menu untuk setiap item
            ->orderBy('created_at') // Urutkan berdasarkan waktu dibuat
            ->get(); // Ambil semua datanya

        return view('pesanan.index', compact('orders')); // Tampilkan ke view dengan data orders
    }

    // Menampilkan halaman form pemesanan (pilih menu)
    public function create()
    {
        $menus = Menu::all(); // Ambil semua data menu dari tabel tb_menu
        return view('pesanan.create', compact('menus')); // Tampilkan ke view form pesanan
    }

    // Menyimpan data pesanan baru dari pelanggan
    public function store(Request $request)
    {
        // Validasi input yang dikirim dari form
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1', // Minimal 1 item harus dipilih
            'items.*.menu_id' => 'required|exists:tb_menu,id', // Setiap item harus memiliki menu_id yang valid
            'items.*.jumlah' => 'required|integer|min:1', // Jumlah harus bilangan bulat minimal 1
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Jika request dari API (expects JSON), kembalikan response JSON
            if ($request->expectsJson()) {
                return $this->jsonResponse(false, 'Validasi gagal', $validator->errors(), 422);
            } else {
                // Jika dari form biasa, kembalikan ke halaman sebelumnya dengan error
                return back()->withErrors($validator)->withInput();
            }
        }

        // Buat pesanan baru dengan id pelanggan dari user yang sedang login
        $order = Order::create([
            'pelanggan_id' => auth()->id(),
        ]);

        // Loop setiap item yang dipesan dan simpan ke tabel order_items
        foreach ($request->items as $item) {
            if ($item['jumlah'] > 0) {
                OrderItem::create([
                    'order_id' => $order->id, // ID pesanan yang baru dibuat
                    'menu_id' => $item['menu_id'], // ID menu yang dipesan
                    'jumlah' => $item['jumlah'], // Jumlah yang dipesan
                ]);
            }
        }

        // Muat ulang relasi untuk menampilkan data menu di response
        $order->load('items.menu');

        // Kembalikan response sesuai dengan jenis request (JSON atau web)
        if ($request->expectsJson()) {
            return $this->jsonResponse(true, 'Pesanan berhasil dibuat', $order);
        } else {
            return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat!');
        }
    }
}
