<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'mpesa_payments';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'amount',
        'phone',
        'transaction_code',
        'status',
        'checkout_id',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
