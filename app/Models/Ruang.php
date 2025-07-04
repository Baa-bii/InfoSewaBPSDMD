<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruang'; // Nama tabel
    protected $fillable = ['nama_ruang', 'kluster','harga', 'gedung', 'kapasitas', 'booking_status']; // Kolom yang bisa diisi massal
}
