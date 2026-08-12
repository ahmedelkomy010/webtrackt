<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function name(): string;

    public function isConfigured(): bool;

    /** @return array<string, mixed> */
    public function formConfig(Order $order, string $callbackUrl): array;

    public function verify(string $paymentId): ?array;

    public function handleWebhook(array $payload): void;

    public function simulatePayment(Order $order, string $method, bool $success): array;
}
