<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'tb_menu';

    // Menentukan kolom-kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'nama',     // Nama menu
        'jenis',    // Jenis menu (makanan/minuman)
        'harga',    // Harga satuan menu
        'stok',     // Jumlah stok yang tersedia
        'gambar',   // Path gambar menu
    ];
    
    // Relasi satu ke banyak: satu menu bisa dimiliki oleh banyak item pesanan
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class); // relasi ke tabel order_items
    }
}
