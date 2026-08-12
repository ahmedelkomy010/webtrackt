<?php

namespace App\Http\Controllers;

use App\Services\Payment\PaymentManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function __construct(protected PaymentManager $payments) {}

    public function moyasar(Request $request): JsonResponse
    {
        $payload = $request->all();

        if ($payload === []) {
            return response()->json(['ok' => false], 400);
        }

        $this->payments->gateway()->handleWebhook($payload);

        return response()->json(['ok' => true]);
    }
}
