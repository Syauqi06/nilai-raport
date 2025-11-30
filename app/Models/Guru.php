<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    protected $guarded = [];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id_pengguna');
    }
}
