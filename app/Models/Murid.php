<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $table = 'murid';
    protected $primaryKey = 'id_murid';
    protected $guarded = [];

    // Relasi dengan model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }
}
