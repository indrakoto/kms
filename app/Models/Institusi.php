<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institusi extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_institusi';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['name', 'description', 'slug'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
