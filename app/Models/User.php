<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

//Mengaktifkan factory
    use HasFactory, Notifiable;
    
//Menentukan bahwa model ini terhubung ke tabel bernama
    protected $table = 'tb_user';
   
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
    ];

    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
