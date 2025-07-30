<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BasisdataAlphabyte extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'basisdata_alphabyte';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = [  
        'title', 
        'content',
        'file_path',
        'thumbnail',
        'is_processed'
    ];
}
