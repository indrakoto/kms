<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertProfile extends Model
{
    use HasFactory;

    // Nama tabel jika berbeda dari konvensi Laravel
    protected $table = 'kms_expert_profiles';

    // Kolom-kolom yang bisa diisi (mass assignment)
    protected $fillable = ['user_id', 'expertise', 'contact_info'];

    // Relasi: satu profil ahli dimiliki oleh satu pengguna
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Relasi belongs to dengan User
    }
}
