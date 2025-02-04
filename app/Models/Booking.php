<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'jadwal_booking';
    protected $primaryKey = 'id'; // Primary key
    protected $fillable = ['nama_pemesan','no_hp','no_ktp', 'nama_ruang', 'kluster', 'gedung','tanggal_start', 'tanggal_end','id_ruang' ]; 

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }

}
