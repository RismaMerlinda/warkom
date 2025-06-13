<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'tb_order_item';
    
//pengisian kolom
    protected $fillable = [
        'order_id',
        'menu_id',
        'jumlah',
    ];

//Menyatakan bahwa setiap item order milik satu Order 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

//Menyatakan bahwa setiap OrderItem menghadirkan satu Menu item
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
