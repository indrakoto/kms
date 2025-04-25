<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_likes';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['article_id', 'user_id'];

    // Relasi: satu like dimiliki oleh satu artikel
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');  // Relasi belongs to dengan Article
    }

    // Relasi: satu like dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Relasi belongs to dengan User
    }
}
