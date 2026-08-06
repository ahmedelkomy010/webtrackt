<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Support\PageCopy;
use Illuminate\Support\Facades\Cache;

class PageContentService
{
    public const CACHE_KEY = 'tract.page.content';

    public const PAGES = ['home', 'about', 'contact', 'privacy'];

    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $stored = SiteSetting::where('key', 'pages')->value('value');

            return $this->mergeDefaults(is_array($stored) ? $stored : []);
        });
    }

    public function page(string $slug): array
    {
        return $this->all()[$slug] ?? $this->defaultPage($slug);
    }

    public function savePage(string $slug, array $data): void
    {
        if (! in_array($slug, self::PAGES, true)) {
            return;
        }

        $all = $this->all();
        $all[$slug] = array_merge($all[$slug] ?? $this->defaultPage($slug), $data);

        SiteSetting::updateOrCreate(
            ['key' => 'pages'],
            ['value' => $all]
        );

        $this->invalidate();
        app(ContentService::class)->invalidate();
    }

    public function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected function mergeDefaults(array $stored): array
    {
        $merged = [];

        foreach (self::PAGES as $page) {
            $merged[$page] = array_replace_recursive(
                $this->defaultPage($page),
                $stored[$page] ?? []
            );
        }

        return $merged;
    }

    protected function defaultPage(string $slug): array
    {
        return match ($slug) {
            'home' => [
                'hero_badge' => [
                    'ar' => 'أول نظام مقاولات متخصص في العقد الموحد',
                    'en' => 'First contracting system specialized in unified contracts',
                    'ur' => 'متحد معاہدوں میں مہارت یافتہ پہلا مقاولات نظام',
                ],
                'hero_headline' => [
                    'ar' => 'حلول رقمية',
                    'en' => 'Digital solutions',
                    'ur' => 'ڈیجیٹل حل',
                ],
                'hero_headline_highlight' => [
                    'ar' => 'تقود نموّك',
                    'en' => 'that drive your growth',
                    'ur' => 'جو آپ کی ترقی کو آگے بڑھائیں',
                ],
                'body' => ['ar' => '', 'en' => '', 'ur' => ''],
            ],
            'about' => [
                'title' => ['ar' => 'من نحن', 'en' => 'About Us', 'ur' => 'ہمارے بارے میں'],
                'badge' => ['ar' => 'عن تراكت', 'en' => 'About Trackkt', 'ur' => 'Trackkt کے بارے میں'],
                'subtitle' => ['ar' => 'شريكك التقني في', 'en' => 'Your technology partner in', 'ur' => 'آپ کا ٹیکنالوجی پارٹنر'],
                'body' => [
                    'ar' => '<p>'.PageCopy::about('ar')['description'].'</p>',
                    'en' => '<p>'.PageCopy::about('en')['description'].'</p>',
                    'ur' => '<p>'.PageCopy::about('ur')['description'].'</p>',
                ],
            ],
            'contact' => [
                'title' => ['ar' => 'تواصل معنا', 'en' => 'Contact Us', 'ur' => 'رابطہ کریں'],
                'badge' => ['ar' => 'تواصل معنا', 'en' => 'Get in touch', 'ur' => 'ہم سے رابطہ'],
                'subtitle' => ['ar' => 'لنبدأ مشروعك اليوم', 'en' => "Let's start your project today", 'ur' => 'آج ہی اپنا پروجیکٹ شروع کریں'],
                'body' => [
                    'ar' => '<p>'.PageCopy::contact('ar')['subtitle'].'</p>',
                    'en' => '<p>'.PageCopy::contact('en')['subtitle'].'</p>',
                    'ur' => '<p>'.PageCopy::contact('ur')['subtitle'].'</p>',
                ],
            ],
            'privacy' => [
                'title' => ['ar' => 'سياسة الخصوصية', 'en' => 'Privacy Policy', 'ur' => 'رازداری کی پالیسی'],
                'badge' => ['ar' => 'خصوصيتك مهمة', 'en' => 'Your privacy matters', 'ur' => 'آپ کی رازداری'],
                'subtitle' => ['ar' => 'كيف نحمي بياناتك', 'en' => 'How we protect your data', 'ur' => 'ہم آپ کے ڈیٹا کی حفاظت کیسے کرتے ہیں'],
                'body' => [
                    'ar' => '<h2>مقدمة</h2><p>نحن في تراكت نلتزم بحماية خصوصيتك. توضح هذه السياسة كيفية جمع واستخدام وحماية بياناتك عند استخدام موقعنا وخدماتنا.</p><h2>البيانات التي نجمعها</h2><ul><li>الاسم والبريد الإلكتروني ورقم الجوال عند التواصل معنا</li><li>بيانات التصفح الأساسية لتحسين تجربة المستخدم</li></ul><h2>استخدام البيانات</h2><p>نستخدم بياناتك للرد على استفساراتك وتقديم خدماتنا وتحسين الموقع.</p><h2>التواصل</h2><p>لأي استفسار حول الخصوصية تواصل معنا عبر صفحة التواصل.</p>',
                    'en' => '<h2>Introduction</h2><p>At Trackkt we are committed to protecting your privacy. This policy explains how we collect, use, and safeguard your data.</p><h2>Data we collect</h2><ul><li>Name, email, and phone when you contact us</li><li>Basic browsing data to improve user experience</li></ul><h2>Contact</h2><p>For privacy inquiries, please use our contact page.</p>',
                    'ur' => '<h2>تعارف</h2><p>Trackkt میں ہم آپ ki رازداری ki حفاظت کے پابند ہیں۔</p>',
                ],
            ],
            default => [],
        };
    }
}
