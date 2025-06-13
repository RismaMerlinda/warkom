<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //menentukan tabel yang digunakan
    protected $table = 'tb_order';

    //memperbarui data
    protected $fillable = [
        'pelanggan_id',
        'waiter_id',
        'status',
    ];
    
    //memiliki banyak item untuk di order
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    //menghubungkan order ke pelanggan yang memesan
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    //menunjukkan user sebagai waiter 
    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    //Menyatakan bahwa setiap order bisa memiliki satu transaksi, misalnya catatan pembayaran
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
