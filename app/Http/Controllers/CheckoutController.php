<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart\CartService;
use App\Support\Locale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index(Request $request): View|RedirectResponse
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        if ($this->cart->isEmpty()) {
            return redirect(Locale::path('cart', $locale, $country));
        }

        return view('checkout.index', [
            'locale' => $locale,
            'country' => $country,
            'siteUrl' => $siteUrl,
            'items' => $this->cart->items(),
            'formattedTotal' => $this->cart->formattedTotal(),
            'total' => $this->cart->total(),
            'currency' => $this->cart->currency(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);

        if ($this->cart->isEmpty()) {
            return redirect(Locale::path('cart', $locale, $country));
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:190'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_company' => ['nullable', 'string', 'max:190'],
            'customer_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $order = DB::transaction(function () use ($validated, $locale, $country) {
            $order = Order::create([
                'status' => Order::STATUS_AWAITING_PAYMENT,
                'payment_status' => Order::PAYMENT_UNPAID,
                'amount' => $this->cart->total(),
                'currency' => $this->cart->currency(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_company' => $validated['customer_company'] ?? null,
                'customer_notes' => $validated['customer_notes'] ?? null,
                'locale' => $locale,
                'country' => $country,
            ]);

            foreach ($this->cart->items() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'offer_index' => $item['offer_index'],
                    'service_slug' => $item['service_slug'],
                    'name' => $item['name'],
                    'price_label' => $item['price_label'],
                    'amount' => $item['amount'],
                    'currency' => $item['currency'],
                ]);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect(Locale::path('checkout/payment/'.$order->uuid, $locale, $country));
    }
}
