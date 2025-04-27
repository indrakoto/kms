<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Neraca extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kms_neraca';

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
        'institusi_id',
        'analisis_id',
        // Tambahkan field lain yang boleh diisi secara massal di sini
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
        'institusi_id' => 'integer', // Atau 'biginteger'
        'analisis_id' => 'integer', // Atau 'biginteger'
    ];

    /**
     * Define the relationship with the KmsInstitusi model.
     */
    public function institusi()
    {
        return $this->belongsTo(Institusi::class, 'institusi_id');
    }

    /**
     * Define the relationship with the KmsAnalisis model (one-to-one).
     */
    public function analisis()
    {
        return $this->belongsTo(Analisis::class, 'analisis_id');
    }
}