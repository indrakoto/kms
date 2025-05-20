<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_articles';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'category_id', 
        'user_id', 
        'title', 
        'content',
        'slug', 
        'embed_code',
        'embed_link',
        'file_path',
        'thumbnail',
        'is_published', 
        'views', 'source_id','institusi_id'];

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
    public function institusi()
    {
        return $this->belongsTo(Institusi::class, 'institusi_id');  // Relasi belongs to dengan Institusi
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

    /**
     * Accessor untuk format tanggal Indonesia
     */
    public function getTanggalIndoAttribute()
    {
        return Carbon::parse($this->created_at)
            ->locale('id_ID') // Set locale ke Indonesia
            ->translatedFormat('j F Y'); // Format: 27 April 2025
    }

    /**
     * Accessor untuk konten dinamis berdasarkan source
     */
    public function getDisplayContentAttribute()
    {
        $sourceName = strtolower($this->source->name);
        switch ($sourceName) {
            case 'text':
                return $this->content; // Mengambil dari field content
                
            case 'pdf':
                return view('components.pdf-viewer', [
                    'file' => Storage::url($this->file_path)
                ]);
                
            case 'video':
                if ($this->embed_code) {
                    return $this->embed_code;
                }
                return view('components.video-player', [
                    'file' => Storage::url($this->video_path)
                ]);
                
            case 'youtube':
                return $this->embed_code;

            case 'link':
                //return $this->embed_link;
                return view('components.link-web-viewer', [
                    'url' => $this->embed_link
                ]);
                
            default:
                return $this->content; // Fallback ke field content
        }
    }

    /**
     * Helper untuk mengecek jenis konten
     */
    public function isType(string $type): bool
    {
        return $this->source->name === $type;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::exists($this->thumbnail)) {
            return Storage::url($this->thumbnail);
        }
        return asset('img/default.png'); // Path ke gambar default
    }


}
