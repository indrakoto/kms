<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_analisis';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['name', 'description', 'institusi_id'];

    public function institusi()
    {
        return $this->belongsTo(Institusi::class, 'institusi_id');  // Relasi belongs to dengan Category
    }
}
