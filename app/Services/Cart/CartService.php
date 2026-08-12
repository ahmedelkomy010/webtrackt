<?php

namespace App\Services\Cart;

use App\Models\Service;
use Illuminate\Support\Collection;

class CartService
{
    protected const SESSION_KEY = 'cart';

    public function items(): Collection
    {
        return collect(session(self::SESSION_KEY.'.items', []));
    }

    public function count(): int
    {
        return $this->items()->count();
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function total(): int
    {
        return (int) $this->items()->sum('amount');
    }

    public function currency(): string
    {
        $first = $this->items()->first();

        return $first['currency'] ?? config('payments.currency', 'SAR');
    }

    public function locale(): string
    {
        return session(self::SESSION_KEY.'.locale', app('locale', 'ar'));
    }

    public function country(): string
    {
        return session(self::SESSION_KEY.'.country', app('country', 'sa'));
    }

    public function add(Service $service, int $offerIndex, string $locale, string $country): bool
    {
        $amount = $service->offerAmount($offerIndex);

        if ($amount <= 0) {
            return false;
        }

        $key = $this->itemKey($service->id, $offerIndex);
        $localized = $service->localizedOffer($offerIndex, $locale);

        $items = $this->items()->put($key, [
            'key' => $key,
            'service_id' => $service->id,
            'offer_index' => $offerIndex,
            'service_slug' => $service->slug,
            'service_title' => $service->localized('title', $locale),
            'name' => $localized['name'],
            'price_label' => $localized['price'],
            'amount' => (int) $localized['amount'],
            'currency' => $offer['currency'] ?? config('payments.currency', 'SAR'),
        ])->all();

        session([
            self::SESSION_KEY => [
                'items' => $items,
                'locale' => $locale,
                'country' => $country,
            ],
        ]);

        return true;
    }

    public function remove(string $key): void
    {
        $items = $this->items()->except($key)->all();
        $this->persistItems($items);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function formattedTotal(): string
    {
        $value = $this->total() / 100;

        return number_format($value, 2).' '.$this->currency();
    }

    protected function itemKey(int $serviceId, int $offerIndex): string
    {
        return $serviceId.'_'.$offerIndex;
    }

    protected function persistItems(array $items): void
    {
        $cart = session(self::SESSION_KEY, []);

        if ($items === []) {
            session()->forget(self::SESSION_KEY);

            return;
        }

        session([
            self::SESSION_KEY => [
                'items' => $items,
                'locale' => $cart['locale'] ?? app('locale', 'ar'),
                'country' => $cart['country'] ?? app('country', 'sa'),
            ],
        ]);
    }
}
