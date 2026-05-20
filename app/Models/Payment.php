<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'payment_method', 'credit_card_number',
        'expiration_date', 'cvv',
    ];

    protected $hidden = ['credit_card_number', 'cvv'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
