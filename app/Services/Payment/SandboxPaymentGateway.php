<?php

namespace App\Services\Payment;

use App\Models\Order;

class SandboxPaymentGateway implements PaymentGatewayInterface
{
    public function name(): string
    {
        return 'sandbox';
    }

    public function isConfigured(): bool
    {
        return true;
    }

    public function formConfig(Order $order, string $callbackUrl): array
    {
        return [
            'driver' => 'sandbox',
            'amount' => $order->amount,
            'currency' => $order->currency,
            'description' => $order->reference,
            'callback_url' => $callbackUrl,
            'methods' => array_keys(config('payments.methods', [])),
            'metadata' => [
                'order_uuid' => $order->uuid,
                'reference' => $order->reference,
            ],
        ];
    }

    public function verify(string $paymentId): ?array
    {
        return null;
    }

    public function handleWebhook(array $payload): void
    {
        //
    }

    public function simulatePayment(Order $order, string $method, bool $success): array
    {
        $payment = [
            'id' => 'sandbox_'.uniqid(),
            'status' => $success ? 'paid' : 'failed',
            'amount' => $order->amount,
            'currency' => $order->currency,
            'source' => ['type' => $method],
        ];

        if ($success) {
            $order->update([
                'payment_gateway' => $this->name(),
                'gateway_payment_id' => $payment['id'],
                'gateway_response' => $payment,
                'payment_method' => $method,
            ]);
            $order->markPaid($payment['id'], $payment, $method);
        } else {
            $order->update([
                'payment_gateway' => $this->name(),
                'gateway_payment_id' => $payment['id'],
                'gateway_response' => $payment,
                'payment_method' => $method,
            ]);
            $order->markFailed($payment);
        }

        return $payment;
    }
}
