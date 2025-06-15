<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'tb_order_item';
    
    // Menentukan kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'order_id', // ID dari pesanan induk (Order)
        'menu_id',  // ID dari menu yang dipesan
        'jumlah',   // Jumlah item menu yang dipesan
    ];

    // Relasi ke model Order
    // Menyatakan bahwa setiap OrderItem milik satu Order
    public function order()
    {
        return $this->belongsTo(Order::class); // Foreign key: order_id
    }

    // Relasi ke model Menu
    // Menyatakan bahwa setiap OrderItem berhubungan dengan satu Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class); // Foreign key: menu_id
    }
}
