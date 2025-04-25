<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_tags';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['name'];

    // Relasi: satu tag bisa memiliki banyak artikel (relasi banyak ke banyak)
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'kms_article_tag', 'tag_id', 'article_id');
    }
    /*
    Penjelasan:
        belongsToMany(Article::class, 'kms_article_tag', 'tag_id', 'article_id')
        Relasi ini mengindikasikan bahwa setiap tag bisa terkait dengan banyak artikel melalui tabel pivot kms_article_tag. 
        Tabel pivot ini memiliki kolom tag_id dan article_id yang menghubungkan kedua tabel (kms_tags dan kms_articles).
     */
}
