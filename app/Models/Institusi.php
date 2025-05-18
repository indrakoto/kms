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
    protected $fillable = ['name', 'description', 'slug', 'parent'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }


    /**
     * Relasi ke child divisions (sub-divisi).
     */
    public function children()
    {
        return $this->hasMany(Institusi::class, 'parent');
    }

    /**
     * Relasi ke parent division (opsional, jika dibutuhkan).
     */
    //public function parent()
    //{
    //    return $this->belongsTo(Institusi::class, 'parent');
    //}

    public function parentRelation()
    {
        return $this->belongsTo(Institusi::class, 'parent'); // Kolom 'parent' sebagai foreign key
    }

    // Ambil menu utama saja (yang tidak punya parent)
    public static function getParentItems()
    {
        return self::with('children')
            ->whereNull('parent')
            ->orderBy('name')
            ->get();
    }

    public static function getMenuInstitusi()
    {
        return self::with(['children' => function($query) {
                $query->orderBy('name');
            }])
            ->whereNull('parent')
            ->orderBy('name')
            ->get();
    }

}
