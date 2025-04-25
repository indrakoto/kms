<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_articles';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['category_id', 'user_id', 'title', 'content', 'file_path', 'is_published', 'views', 'source_id'];

    // Relasi: satu artikel dimiliki oleh satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');  // Relasi belongs to dengan Category
    }

    // Relasi: satu artikel dimiliki oleh satu user (penulis)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Relasi belongs to dengan User
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');  // Relasi belongs to dengan Source
    }

    // Relasi: satu artikel bisa memiliki banyak tag (relasi banyak ke banyak)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'kms_article_tag', 'article_id', 'tag_id');
    }
    /*
    Penjelasan:
        belongsToMany(Tag::class, 'kms_article_tag', 'article_id', 'tag_id')
        Relasi ini menunjukkan bahwa satu artikel bisa memiliki banyak tag. 
        Tabel pivot kms_article_tag menghubungkan artikel dengan tag, di mana kolom article_id menghubungkan ke artikel dan tag_id menghubungkan ke tag.
    */

    // Relasi: satu artikel memiliki banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');  // Relasi one to many dengan Comment
    }

    // Relasi: satu artikel bisa memiliki banyak like
    public function likes()
    {
        return $this->hasMany(Like::class, 'article_id');  // Relasi one to many dengan Like
    }
}
