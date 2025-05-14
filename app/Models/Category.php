<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_categories';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['name', 'description', 'slug'];

    // Relasi: satu kategori memiliki banyak artikel
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');  // Relasi one to many dengan Artikel
    }
}