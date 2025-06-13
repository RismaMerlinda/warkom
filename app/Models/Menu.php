<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'tb_menu';

//menentukan kolom-kolom yang dapat diis
    protected $fillable = [
        'nama',
        'jenis',
        'harga',
        'stok',
        'gambar',
    ];
    
//Menyatakan bahwa satu menu bisa muncul di banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
