<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_AWAITING_PAYMENT = 'awaiting_payment';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_UNPAID = 'unpaid';

    public const PAYMENT_PROCESSING = 'processing';

    public const PAYMENT_PAID = 'paid';

    public const PAYMENT_FAILED = 'failed';

    protected $fillable = [
        'uuid',
        'reference',
        'status',
        'payment_status',
        'payment_method',
        'payment_gateway',
        'gateway_payment_id',
        'gateway_response',
        'amount',
        'currency',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_company',
        'customer_notes',
        'locale',
        'country',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (! $order->uuid) {
                $order->uuid = (string) Str::uuid();
            }

            if (! $order->reference) {
                $order->reference = self::generateReference();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function formattedAmount(): string
    {
        $value = $this->amount / 100;

        return number_format($value, 2).' '.$this->currency;
    }

    public static function generateReference(): string
    {
        do {
            $reference = 'TRK-'.now()->format('ymd').'-'.strtoupper(Str::random(6));
        } while (static::where('reference', $reference)->exists());

        return $reference;
    }

    public function markPaid(?string $paymentId = null, ?array $response = null, ?string $method = null): void
    {
        $this->update([
            'status' => self::STATUS_PAID,
            'payment_status' => self::PAYMENT_PAID,
            'gateway_payment_id' => $paymentId ?? $this->gateway_payment_id,
            'gateway_response' => $response ?? $this->gateway_response,
            'payment_method' => $method ?? $this->payment_method,
            'paid_at' => now(),
        ]);
    }

    public function markFailed(?array $response = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'payment_status' => self::PAYMENT_FAILED,
            'gateway_response' => $response ?? $this->gateway_response,
        ]);
    }
}
