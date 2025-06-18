<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'forum_threads';

    protected $fillable = ['user_id', 'title', 'content'];
    //protected $fillable = ['user_id', 'article_id', 'title', 'content'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /*public function article()
    {
        return $this->belongsTo(Article::class);
    }*/
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
