<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'start_date',
        'end_date',
        'amount_paid',
        'transaction_type',
        'downloads_today',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
