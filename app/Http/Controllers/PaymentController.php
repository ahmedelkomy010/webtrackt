<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\MoyasarGateway;
use App\Services\Payment\PaymentManager;
use App\Support\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentManager $payments,
        protected MoyasarGateway $moyasar,
    ) {}

    public function show(Request $request, Order $order): View|RedirectResponse
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        if ($order->isPaid()) {
            return redirect(Locale::path('checkout/success/'.$order->uuid, $locale, $country));
        }

        if ($order->payment_status === Order::PAYMENT_FAILED) {
            $order->update([
                'payment_status' => Order::PAYMENT_UNPAID,
                'status' => Order::STATUS_AWAITING_PAYMENT,
            ]);
        }

        $gateway = $this->payments->gateway();
        $callbackUrl = url('/checkout/callback?order='.$order->uuid);

        return view('checkout.payment', [
            'locale' => $locale,
            'country' => $country,
            'siteUrl' => $siteUrl,
            'order' => $order->load('items'),
            'paymentConfig' => $gateway->formConfig($order, $callbackUrl),
            'usesLiveGateway' => $this->payments->usesLiveGateway(),
            'methods' => config('payments.methods', []),
        ]);
    }

    public function process(Request $request, Order $order): RedirectResponse
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);

        if ($order->isPaid()) {
            return redirect(Locale::path('checkout/success/'.$order->uuid, $locale, $country));
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:'.implode(',', array_keys(config('payments.methods', [])))],
            'simulate_result' => ['nullable', 'in:success,failed'],
        ]);

        $gateway = $this->payments->gateway();

        if ($gateway->name() === 'sandbox') {
            $success = ($validated['simulate_result'] ?? 'success') === 'success';
            $gateway->simulatePayment($order, $validated['payment_method'], $success);

            return $success
                ? redirect(Locale::path('checkout/success/'.$order->uuid, $locale, $country))
                : redirect(Locale::path('checkout/cancel/'.$order->uuid, $locale, $country));
        }

        return back()->withErrors([
            'payment' => $locale === 'en'
                ? 'Complete payment using the form below.'
                : ($locale === 'ur' ? 'نیچے دیے گئے فارم سے ادائیگی مکمل کریں۔' : 'أكمل الدفع باستخدام النموذج أدناه.'),
        ]);
    }

    public function callback(Request $request): RedirectResponse
    {
        $orderUuid = $request->query('order') ?? $request->query('order_uuid');
        $paymentId = $request->query('id');

        $order = Order::where('uuid', $orderUuid)->firstOrFail();
        $locale = $order->locale ?: Locale::AR;
        $country = $order->country ?: 'sa';

        if ($paymentId && $this->payments->usesLiveGateway()) {
            $payment = $this->moyasar->verify($paymentId);

            if ($payment) {
                $this->moyasar->syncOrderFromPayment($order->fresh(), $payment);
            }
        }

        $order->refresh();

        if ($order->isPaid()) {
            return redirect(Locale::path('checkout/success/'.$order->uuid, $locale, $country));
        }

        return redirect(Locale::path('checkout/cancel/'.$order->uuid, $locale, $country));
    }

    public function success(Request $request, Order $order): View
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        return view('checkout.success', [
            'locale' => $locale,
            'country' => $country,
            'siteUrl' => $siteUrl,
            'order' => $order->load('items'),
        ]);
    }

    public function cancel(Request $request, Order $order): View
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        return view('checkout.cancel', [
            'locale' => $locale,
            'country' => $country,
            'siteUrl' => $siteUrl,
            'order' => $order->load('items'),
        ]);
    }
}
