<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'service_id',
        'offer_index',
        'service_slug',
        'name',
        'price_label',
        'amount',
        'currency',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function formattedAmount(): string
    {
        $value = $this->amount / 100;

        return number_format($value, 2).' '.$this->currency;
    }
}
