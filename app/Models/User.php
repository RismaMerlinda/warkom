<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Mengaktifkan fitur factory untuk keperluan seeding dan testing
    // serta fitur notifikasi bawaan Laravel
    use HasFactory, Notifiable;
    
    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'tb_user';
   
    // Kolom-kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'nama_user',   // Nama lengkap user
        'username',    // Username untuk login
        'password',    // Password user (akan dienkripsi)
        'role',        // Peran user (admin, kasir, waiter, pelanggan)
    ];

    // Kolom yang disembunyikan saat model diubah menjadi array atau JSON
    protected $hidden = [
        'password', // Password tidak akan ditampilkan untuk alasan keamanan
    ];

    // Relasi satu ke banyak: satu user bisa memiliki banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class); // relasi ke tabel orders berdasarkan user_id
    }
}
