<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel'; // Menentukan nama tabel yaitu 'mapel'
    protected $primaryKey = 'id_mapel'; // Menentukan primary key yaitu 'id_mapel'
    protected $guarded = []; // Mengizinkan semua kolom untuk dapat diisi massal
    protected $casts = [
        'mapel_aktif' => 'boolean', // Mengubah kolom 'mapel_aktif' menjadi tipe boolean
    ];
}
