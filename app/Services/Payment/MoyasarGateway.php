<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoyasarGateway implements PaymentGatewayInterface
{
    public function name(): string
    {
        return 'moyasar';
    }

    public function isConfigured(): bool
    {
        return filled(config('payments.moyasar.publishable_key'))
            && filled(config('payments.moyasar.secret_key'));
    }

    public function formConfig(Order $order, string $callbackUrl): array
    {
        return [
            'driver' => 'moyasar',
            'amount' => $order->amount,
            'currency' => $order->currency,
            'description' => $order->reference,
            'publishable_key' => config('payments.moyasar.publishable_key'),
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
        if (! $this->isConfigured()) {
            return null;
        }

        $response = Http::withBasicAuth(config('payments.moyasar.secret_key'), '')
            ->get(config('payments.moyasar.api_url').'/payments/'.$paymentId);

        if (! $response->successful()) {
            Log::warning('Moyasar verify failed', ['payment_id' => $paymentId, 'body' => $response->body()]);

            return null;
        }

        return $response->json();
    }

    public function handleWebhook(array $payload): void
    {
        $paymentId = $payload['id'] ?? null;
        $metadata = $payload['metadata'] ?? [];
        $orderUuid = $metadata['order_uuid'] ?? null;

        if (! $orderUuid) {
            return;
        }

        $order = Order::where('uuid', $orderUuid)->first();

        if (! $order) {
            return;
        }

        $this->syncOrderFromPayment($order, $payload);
    }

    public function simulatePayment(Order $order, string $method, bool $success): array
    {
        return [
            'id' => 'moy_sim_'.uniqid(),
            'status' => $success ? 'paid' : 'failed',
            'amount' => $order->amount,
            'currency' => $order->currency,
            'source' => ['type' => $method],
        ];
    }

    public function syncOrderFromPayment(Order $order, array $payment): void
    {
        $status = $payment['status'] ?? '';
        $method = data_get($payment, 'source.type');

        if (in_array($status, ['paid', 'captured', 'authorized'], true)) {
            $order->update([
                'payment_gateway' => $this->name(),
                'gateway_payment_id' => $payment['id'] ?? $order->gateway_payment_id,
                'gateway_response' => $payment,
            ]);
            $order->markPaid($payment['id'] ?? null, $payment, $method);

            return;
        }

        if (in_array($status, ['failed', 'voided', 'refunded'], true)) {
            $order->update([
                'payment_gateway' => $this->name(),
                'gateway_payment_id' => $payment['id'] ?? $order->gateway_payment_id,
                'gateway_response' => $payment,
            ]);
            $order->markFailed($payment);
        }
    }
}
