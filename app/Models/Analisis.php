<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Analisis extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_analisis';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int'; // Atau 'bigint' jika tipe ID Anda bigint

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        // Daftar semua field di tabel kms_analisis yang boleh diisi massal
        // Contoh: 'nama_analisis', 'nilai', 'tanggal', dll.
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer', // Atau 'biginteger' jika tipe ID Anda bigint
        // Contoh: 'tanggal' => 'datetime', 'nilai' => 'decimal:2',
    ];

    /**
     * Define the inverse relationship with the KmsNeraca model (one-to-many).
     * An Analisis entry can be associated with many Neraca entries.
     */
    public function neracas()
    {
        return $this->hasMany(Neraca::class, 'analisis_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
