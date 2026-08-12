<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\Cart\CartService;
use App\Support\Locale;
use App\Support\SiteUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index(Request $request): View|RedirectResponse
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);
        $siteUrl = rtrim(config('tract.website'), '/');

        if ($this->cart->isEmpty()) {
            return view('cart.index', [
                'locale' => $locale,
                'country' => $country,
                'siteUrl' => $siteUrl,
                'items' => collect(),
                'total' => 0,
                'formattedTotal' => '0.00 '.config('payments.currency', 'SAR'),
            ]);
        }

        return view('cart.index', [
            'locale' => $locale,
            'country' => $country,
            'siteUrl' => $siteUrl,
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
            'formattedTotal' => $this->cart->formattedTotal(),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'offer_index' => ['required', 'integer', 'min:0', 'max:2'],
        ]);

        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);

        $service = Service::where('is_active', true)->findOrFail($validated['service_id']);

        if (! $this->cart->add($service, (int) $validated['offer_index'], $locale, $country)) {
            return back()->withErrors([
                'cart' => $locale === 'en'
                    ? 'This package is not available for online purchase.'
                    : ($locale === 'ur' ? 'یہ پیکج آن لائن خریداری کے لیے دستیاب نہیں۔' : 'هذه الباقة غير متاحة للشراء الإلكتروني.'),
            ]);
        }

        return redirect(Locale::path('cart', $locale, $country))
            ->with('success', $locale === 'en'
                ? 'Package added to cart.'
                : ($locale === 'ur' ? 'پیکج کارٹ میں شامل ہو گیا۔' : 'تمت إضافة الباقة إلى السلة.'));
    }

    public function remove(Request $request, string $key): RedirectResponse
    {
        $locale = Locale::fromRequest($request);
        $country = Locale::countryFromRequest($request);

        $this->cart->remove($key);

        return redirect(Locale::path('cart', $locale, $country))
            ->with('success', $locale === 'en'
                ? 'Item removed from cart.'
                : ($locale === 'ur' ? 'آئٹم کارٹ سے ہٹا دیا گیا۔' : 'تمت إزالة الباقة من السلة.'));
    }
}
