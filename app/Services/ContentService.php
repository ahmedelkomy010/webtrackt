<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Models\NavLink;
use App\Models\Review;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\WhyUsItem;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    public const CACHE_KEY = 'tract_site_content';

    public function all(): array
    {
        return Cache::remember(self::CACHE_KEY, 3600, fn () => $this->load());
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected function load(): array
    {
        return [
            'version' => now()->timestamp,
            'services' => Service::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Service $s) => [
                    'id' => $s->id,
                    'slug' => $s->slug,
                    'icon' => $s->icon,
                    'highlight' => $s->highlight,
                    'title' => $s->title,
                    'description' => $s->description,
                    'features' => $s->features,
                ])
                ->values()
                ->all(),
            'stats' => Stat::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Stat $s) => [
                    'id' => $s->id,
                    'value' => $s->value,
                    'label' => $s->label,
                ])
                ->values()
                ->all(),
            'whyUs' => WhyUsItem::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (WhyUsItem $w) => [
                    'id' => $w->id,
                    'title' => $w->title,
                    'description' => $w->description,
                ])
                ->values()
                ->all(),
            'navLinks' => NavLink::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (NavLink $n) => [
                    'id' => $n->id,
                    'href' => $n->href,
                    'label' => $n->label,
                ])
                ->values()
                ->all(),
            'reviews' => Review::approved()
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->latest()
                ->get()
                ->map(fn (Review $r) => [
                    'id' => $r->id,
                    'name' => $r->name,
                    'company' => $r->company,
                    'rating' => $r->rating,
                    'comment' => $r->comment,
                    'isFeatured' => $r->is_featured,
                ])
                ->values()
                ->all(),
            'settings' => SiteSetting::all()
                ->pluck('value', 'key')
                ->all(),
        ];
    }

    public function dashboardStats(): array
    {
        return [
            'services' => Service::count(),
            'stats' => Stat::count(),
            'why_us' => WhyUsItem::count(),
            'nav_links' => NavLink::count(),
            'messages' => ContactMessage::count(),
            'posts' => \App\Models\Post::count(),
            'published_posts' => \App\Models\Post::published()->count(),
            'reviews' => Review::count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'unread_messages' => ContactMessage::where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
}
