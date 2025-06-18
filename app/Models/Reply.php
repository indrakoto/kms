<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'forum_replies';

    protected $fillable = ['user_id', 'thread_id', 'content'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
