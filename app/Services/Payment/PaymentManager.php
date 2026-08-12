<?php

namespace App\Services\Payment;

class PaymentManager
{
    public function __construct(
        protected MoyasarGateway $moyasar,
        protected SandboxPaymentGateway $sandbox,
    ) {}

    public function gateway(): PaymentGatewayInterface
    {
        $driver = config('payments.driver', 'sandbox');

        if ($driver === 'moyasar' && $this->moyasar->isConfigured()) {
            return $this->moyasar;
        }

        if ($this->moyasar->isConfigured() && $driver !== 'sandbox') {
            return $this->moyasar;
        }

        return $this->sandbox;
    }

    public function usesLiveGateway(): bool
    {
        return $this->gateway()->name() === 'moyasar';
    }
}
