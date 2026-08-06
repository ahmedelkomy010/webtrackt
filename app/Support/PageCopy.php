<?php

namespace App\Support;

class PageCopy
{
    public static function fieldSet(string $key, string $ar, string $en, string $ur): array
    {
        return ['ar' => $ar, 'en' => $en, 'ur' => $ur];
    }

    public static function localized(array $page, string $field, string $locale): string
    {
        $value = $page[$field] ?? [];

        if (! is_array($value)) {
            return (string) $value;
        }

        return $value[$locale] ?? $value['ar'] ?? $value['en'] ?? '';
    }

    public static function about(string $locale): array
    {
        return match ($locale) {
            'en' => [
                'title' => 'About Us',
                'badge' => 'About Trackkt',
                'heading' => 'Your technology partner in',
                'description' => 'We specialize in integrated digital solutions for companies and organizations. We combine technical expertise with deep local market understanding to deliver products that serve your goals.',
                'location' => 'Location',
                'currency' => 'Currency',
                'legalStatus' => 'Legal status',
                'legalValue' => 'Registered — Commercial register & tax',
            ],
            'ur' => [
                'title' => 'ہمارے بارے میں',
                'badge' => 'Trackkt کے بارے میں',
                'heading' => 'آپ کا ٹیکنالوجی پارٹنر',
                'description' => 'ہم کمپنیوں اور اداروں کے لیے جامع ڈیجیٹل حل فراہم کرنے میں مہارت رکھتے ہیں۔ ہم تکنیکی مہارت کو مقامی مارکیٹ کی گہری سمجھ کے ساتھ ملا کر آپ کے مقاصد کی خدمت کرنے والے مصنوعات پیش کرتے ہیں۔',
                'location' => 'مقام',
                'currency' => 'کرنسی',
                'legalStatus' => 'قانونی حیثیت',
                'legalValue' => 'رجسٹرڈ — تجارتی رجسٹر اور ٹیکس',
            ],
            default => [
                'title' => 'من نحن',
                'badge' => 'عن تراكت',
                'heading' => 'شريكك التقني في',
                'description' => 'نحن شركة متخصصة في تقديم حلول رقمية متكاملة للشركات والمؤسسات. نجمع بين الخبرة التقنية والفهم العميق للسوق المحلي لنقدّم لك منتجات تخدم أهدافك.',
                'location' => 'الموقع',
                'currency' => 'العملة',
                'legalStatus' => 'الحالة القانونية',
                'legalValue' => 'مسجلة — سجل تجاري & ضريبة',
            ],
        };
    }

    public static function contact(string $locale): array
    {
        return match ($locale) {
            'en' => [
                'title' => 'Contact Us',
                'badge' => 'Get in touch',
                'heading' => "Let's start your project today",
                'subtitle' => 'Send us your project details and our team will contact you within 24 hours.',
                'email' => 'Email',
                'phone' => 'Phone',
                'whatsapp' => 'WhatsApp',
                'whatsappAction' => 'Chat now',
                'name' => 'Name',
                'namePlaceholder' => 'Your full name',
                'emailLabel' => 'Email',
                'phoneLabel' => 'Phone',
                'service' => 'Required service',
                'servicePlaceholder' => 'Choose a service',
                'message' => 'Project details',
                'messagePlaceholder' => 'Tell us about your project...',
                'submit' => 'Send request',
                'submitting' => 'Sending...',
                'success' => 'Your message was sent successfully! We will contact you soon.',
                'error' => 'Something went wrong. Please try again.',
                'services' => ['ERP Systems', 'Website', 'E-commerce Store', 'Digital Marketing', 'General consultation'],
            ],
            'ur' => [
                'title' => 'رابطہ کریں',
                'badge' => 'ہم سے رابطہ',
                'heading' => 'آج ہی اپنا پروجیکٹ شروع کریں',
                'subtitle' => 'اپنے پروجیکٹ کی تفصیلات بھیجیں، ہماری ٹیم 24 گھنٹوں میں رابطہ کرے گی۔',
                'email' => 'ای میل',
                'phone' => 'فون',
                'whatsapp' => 'واٹس ایپ',
                'whatsappAction' => 'فوری رابطہ',
                'name' => 'نام',
                'namePlaceholder' => 'آپ کا پورا نام',
                'emailLabel' => 'ای میل',
                'phoneLabel' => 'موبائل',
                'service' => 'مطلوبہ خدمت',
                'servicePlaceholder' => 'خدمت منتخب کریں',
                'message' => 'پروجیکٹ کی تفصیلات',
                'messagePlaceholder' => 'اپنے پروجیکٹ کے بارے میں بتائیں...',
                'submit' => 'درخواست بھیجیں',
                'submitting' => 'بھیجا جا رہا ہے...',
                'success' => 'آپ کا پیغام کامیابی سے بھیج دیا گیا!',
                'error' => 'خرابی ہوئی، دوبارہ کوشش کریں۔',
                'services' => ['ERP سسٹمز', 'ویب سائٹ', 'ای کامرس اسٹور', 'ڈیجیٹل مارکیٹنگ', 'عام مشاورت'],
            ],
            default => [
                'title' => 'تواصل معنا',
                'badge' => 'تواصل معنا',
                'heading' => 'لنبدأ مشروعك اليوم',
                'subtitle' => 'أرسل لنا تفاصيل مشروعك وسيتواصل معك فريقنا خلال 24 ساعة.',
                'email' => 'البريد الإلكتروني',
                'phone' => 'الهاتف',
                'whatsapp' => 'واتساب',
                'whatsappAction' => 'تواصل فوري',
                'name' => 'الاسم',
                'namePlaceholder' => 'اسمك الكامل',
                'emailLabel' => 'البريد الإلكتروني',
                'phoneLabel' => 'الجوال',
                'service' => 'الخدمة المطلوبة',
                'servicePlaceholder' => 'اختر الخدمة',
                'message' => 'تفاصيل المشروع',
                'messagePlaceholder' => 'أخبرنا عن مشروعك...',
                'submit' => 'إرسال الطلب',
                'submitting' => 'جاري الإرسال...',
                'success' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.',
                'error' => 'حدث خطأ، يرجى المحاولة مرة أخرى.',
                'services' => ['أنظمة ERP', 'موقع إلكتروني', 'متجر إلكتروني', 'تسويق إلكتروني', 'استشارة عامة'],
            ],
        };
    }
}
