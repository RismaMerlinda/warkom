<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    // Fungsi utama yang akan dijalankan saat seeder dieksekusi
    public function run(): void
    {
        // Daftar data menu yang akan dimasukkan ke dalam tabel tb_menu
        $menus = [
            // Setiap item mewakili satu menu dengan detail: nama, jenis, harga, stok, dan gambar
            ['nama' => 'Air Putih Dingin', 'jenis' => 'minuman', 'harga' => 3000, 'stok' => 50, 'gambar' => 'gambar/airputihdingin.jpg'],
            ['nama' => 'Ayam Kecap', 'jenis' => 'makanan', 'harga' => 18000, 'stok' => 20, 'gambar' => 'gambar/ayam kecap.png'],
            ['nama' => 'Ayam Pop', 'jenis' => 'makanan', 'harga' => 20000, 'stok' => 15, 'gambar' => 'gambar/ayam pop.png'],
            ['nama' => 'Ayam Rica Rica', 'jenis' => 'makanan', 'harga' => 22000, 'stok' => 10, 'gambar' => 'gambar/ayam rica rica.png'],
            // ... (data lainnya dilanjutkan seperti di atas)
            ['nama' => 'Siomay', 'jenis' => 'makanan', 'harga' => 10000, 'stok' => 15, 'gambar' => 'gambar/siomay.png'],
        ];

        // Melakukan perulangan pada setiap item menu dan memasukkannya ke dalam tabel
        foreach ($menus as $menu) {
            DB::table('tb_menu')->insert([
                'nama' => $menu['nama'],           // Nama menu
                'jenis' => $menu['jenis'],         // Jenis menu (makanan/minuman)
                'harga' => $menu['harga'],         // Harga menu
                'stok' => $menu['stok'],           // Jumlah stok menu
                'gambar' => $menu['gambar'],       // Path gambar menu
                'created_at' => now(),             // Timestamp pembuatan (saat ini)
                'updated_at' => now(),             // Timestamp pembaruan (saat ini)
            ]);
        }
    }
}
