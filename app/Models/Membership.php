<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    /**
     * Nama tabel.
     */
    protected $table = 'memberships';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',          // Nama paket membership
        'duration_days', // Durasi membership (hari)
        'daily_limit',   // Batas download per hari
        'price',         // Harga membership
        'is_popular',    // Apakah paket ini populer
    ];

    /**
     * Relasi ke model MembershipTransaction.
     */
    public function transactions()
    {
        return $this->hasMany(MembershipTransaction::class);
    }
}
