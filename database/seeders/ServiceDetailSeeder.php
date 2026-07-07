<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceDetailSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'erp-systems' => [
                'slug' => 'erp-systems',
                'body' => [
                    'ar' => '<p>نقدم في <strong>Trackkt</strong> حلول ERP متخصصة في <strong>نظام العقود الموحدة</strong> للمقاولات والشركات في السعودية والخليج. من إدارة المشاريع والميزانيات إلى الفوترة الإلكترونية ZATCA — نظام واحد يدير كل عملياتك.</p><p>فريقنا يصمم وينفّذ ويدعم أنظمة ERP مخصصة لقطاع المقاولات مع مشاريع تسليم مفتاح كاملة.</p>',
                    'en' => '<p>At <strong>Trackkt</strong>, we deliver specialized ERP solutions for the <strong>unified contract system</strong> in Saudi Arabia and GCC. From project management to ZATCA e-invoicing — one system for all operations.</p>',
                    'ur' => '<p><strong>Trackkt</strong> متحد معاہدہ نظام کے لیے خصوصی ERP حل فراہم کرتا ہے۔</p>',
                ],
                'offers' => [
                    [
                        'name' => ['ar' => 'باقة التأسيس', 'en' => 'Starter Package', 'ur' => 'اسٹارٹر پیکج'],
                        'price' => ['ar' => 'من 25,000 ر.س', 'en' => 'From 25,000 SAR', 'ur' => '25,000 SAR سے'],
                        'features' => [
                            ['ar' => 'تحليل احتياجات العمل', 'en' => 'Business needs analysis', 'ur' => 'کاروباری ضروریات کا تجزیہ'],
                            ['ar' => 'إعداد نظام العقود', 'en' => 'Contract system setup', 'ur' => 'معاہدہ نظام سیٹ اپ'],
                            ['ar' => 'تدريب الفريق', 'en' => 'Team training', 'ur' => 'ٹیم کی تربیت'],
                        ],
                        'highlight' => false,
                    ],
                    [
                        'name' => ['ar' => 'باقة المؤسسات', 'en' => 'Enterprise Package', 'ur' => 'انٹرپرائز پیکج'],
                        'price' => ['ar' => 'من 75,000 ر.س', 'en' => 'From 75,000 SAR', 'ur' => '75,000 SAR سے'],
                        'features' => [
                            ['ar' => 'ERP كامل متكامل', 'en' => 'Full integrated ERP', 'ur' => 'مکمل ERP'],
                            ['ar' => 'لوحات تحكم ذكية', 'en' => 'Smart dashboards', 'ur' => 'سمارٹ ڈیش بورڈز'],
                            ['ar' => 'دعم 12 شهر', 'en' => '12 months support', 'ur' => '12 ماہ سپورٹ'],
                            ['ar' => 'تكامل ZATCA', 'en' => 'ZATCA integration', 'ur' => 'ZATCA انضمام'],
                        ],
                        'highlight' => true,
                    ],
                    [
                        'name' => ['ar' => 'تسليم مفتاح', 'en' => 'Turnkey Project', 'ur' => 'ٹرن کی پروجیکٹ'],
                        'price' => ['ar' => 'حسب المشروع', 'en' => 'Custom quote', 'ur' => 'حسب منصوبہ'],
                        'features' => [
                            ['ar' => 'تصميم + تطوير + تشغيل', 'en' => 'Design + develop + deploy', 'ur' => 'ڈیزائن + ڈvelopment'],
                            ['ar' => 'فريق مخصص', 'en' => 'Dedicated team', 'ur' => 'مخصوص ٹیم'],
                            ['ar' => 'SLA مضمون', 'en' => 'Guaranteed SLA', 'ur' => 'SLA گارنٹی'],
                        ],
                        'highlight' => false,
                    ],
                ],
            ],
            'websites' => [
                'slug' => 'websites',
                'body' => [
                    'ar' => '<p>نصمم ونطور <strong>مواقع إلكترونية احترافية</strong> سريعة ومتجاوبة مع SEO محسّن من اليوم الأول. موقعك هو واجهة عملك الرقمية — نجعلها تعكس هويتك وتحقق أهدافك.</p>',
                    'en' => '<p>We design and develop <strong>professional websites</strong> — fast, responsive, and SEO-optimized from day one.</p>',
                    'ur' => '<p>ہم پیشہ ورانہ، تیز اور SEO optimized ویب سائٹس بناتے ہیں۔</p>',
                ],
                'offers' => [
                    [
                        'name' => ['ar' => 'موقع تعريفي', 'en' => 'Landing Website', 'ur' => 'تعارفی ویب سائٹ'],
                        'price' => ['ar' => 'من 5,000 ر.س', 'en' => 'From 5,000 SAR', 'ur' => '5,000 SAR سے'],
                        'features' => [
                            ['ar' => '5 صفحات', 'en' => '5 pages', 'ur' => '5 صفحات'],
                            ['ar' => 'تصميم متجاوب', 'en' => 'Responsive design', 'ur' => 'ریسپانسیو'],
                            ['ar' => 'SEO أساسي', 'en' => 'Basic SEO', 'ur' => 'بنیادی SEO'],
                        ],
                        'highlight' => false,
                    ],
                    [
                        'name' => ['ar' => 'موقع احترافي', 'en' => 'Professional Site', 'ur' => 'پروفیشنل سائٹ'],
                        'price' => ['ar' => 'من 12,000 ر.س', 'en' => 'From 12,000 SAR', 'ur' => '12,000 SAR سے'],
                        'features' => [
                            ['ar' => 'صفحات غير محدودة', 'en' => 'Unlimited pages', 'ur' => 'لامحدود صفحات'],
                            ['ar' => 'SEO متقدم', 'en' => 'Advanced SEO', 'ur' => 'اعلی SEO'],
                            ['ar' => 'لوحة تحكم', 'en' => 'Admin panel', 'ur' => 'ایڈمن پینل'],
                            ['ar' => 'دعم 6 أشهر', 'en' => '6 months support', 'ur' => '6 ماہ سپورٹ'],
                        ],
                        'highlight' => true,
                    ],
                ],
            ],
            'e-commerce' => [
                'slug' => 'e-commerce',
                'body' => [
                    'ar' => '<p>متاجر إلكترونية متكاملة مع <strong>بوابات دفع محلية</strong> (Mada, Apple Pay, STC Pay)، إدارة مخزون، وتحليلات مبيعات — كل ما تحتاجه للبيع أونلاين في السعودية.</p>',
                    'en' => '<p>Full e-commerce stores with <strong>local payment gateways</strong>, inventory management, and sales analytics.</p>',
                    'ur' => '<p>مقامی ادائیگی گیٹ ویز کے ساتھ مکمل ای کامرس اسٹورز۔</p>',
                ],
                'offers' => [
                    [
                        'name' => ['ar' => 'متجر أساسي', 'en' => 'Basic Store', 'ur' => 'بنیادی اسٹور'],
                        'price' => ['ar' => 'من 15,000 ر.س', 'en' => 'From 15,000 SAR', 'ur' => '15,000 SAR سے'],
                        'features' => [
                            ['ar' => '100 منتج', 'en' => '100 products', 'ur' => '100 مصنوعات'],
                            ['ar' => 'بوابة دفع واحدة', 'en' => '1 payment gateway', 'ur' => '1 ادائیگی گیٹ'],
                            ['ar' => 'إدارة طلبات', 'en' => 'Order management', 'ur' => 'آرڈر مینجمنٹ'],
                        ],
                        'highlight' => false,
                    ],
                    [
                        'name' => ['ar' => 'متجر متقدم', 'en' => 'Advanced Store', 'ur' => 'اعلی اسٹور'],
                        'price' => ['ar' => 'من 35,000 ر.س', 'en' => 'From 35,000 SAR', 'ur' => '35,000 SAR سے'],
                        'features' => [
                            ['ar' => 'منتجات غير محدودة', 'en' => 'Unlimited products', 'ur' => 'لامحدود مصنوعات'],
                            ['ar' => 'Mada + Apple Pay + STC', 'en' => 'Mada + Apple Pay + STC', 'ur' => 'Mada + Apple Pay'],
                            ['ar' => 'تطبيق جوال', 'en' => 'Mobile app', 'ur' => 'موبائل ایپ'],
                            ['ar' => 'تحليلات مبيعات', 'en' => 'Sales analytics', 'ur' => 'سیلز تجزیہ'],
                        ],
                        'highlight' => true,
                    ],
                ],
            ],
            'digital-marketing' => [
                'slug' => 'digital-marketing',
                'body' => [
                    'ar' => '<p>استراتيجيات <strong>تسويق إلكتروني</strong> مدروسة — SEO، إعلانات Google و Meta، سوشيال ميديا، وتحليل ROI. نرفع ظهورك على Google ونجلب عملاء جدد.</p>',
                    'en' => '<p>Strategic <strong>digital marketing</strong> — SEO, Google & Meta ads, social media, and ROI analysis.</p>',
                    'ur' => '<p>اسٹریٹجک ڈیجیٹل مارکیٹنگ — SEO، Google ads، ROI تجزیہ۔</p>',
                ],
                'offers' => [
                    [
                        'name' => ['ar' => 'باقة SEO', 'en' => 'SEO Package', 'ur' => 'SEO پیکج'],
                        'price' => ['ar' => 'من 3,000 ر.س/شهر', 'en' => 'From 3,000 SAR/mo', 'ur' => '3,000 SAR/ماہ'],
                        'features' => [
                            ['ar' => 'تحسين محركات البحث', 'en' => 'Search engine optimization', 'ur' => 'SEO'],
                            ['ar' => 'محتوى شهري', 'en' => 'Monthly content', 'ur' => 'ماہانہ مواد'],
                            ['ar' => 'تقارير أداء', 'en' => 'Performance reports', 'ur' => 'کارکردگی رپورٹس'],
                        ],
                        'highlight' => false,
                    ],
                    [
                        'name' => ['ar' => 'باقة شاملة', 'en' => 'Full Marketing', 'ur' => 'مکمل مارکیٹنگ'],
                        'price' => ['ar' => 'من 8,000 ر.س/شهر', 'en' => 'From 8,000 SAR/mo', 'ur' => '8,000 SAR/ماہ'],
                        'features' => [
                            ['ar' => 'SEO + إعلانات Google', 'en' => 'SEO + Google Ads', 'ur' => 'SEO + Google Ads'],
                            ['ar' => 'Meta & Snapchat Ads', 'en' => 'Meta & Snapchat Ads', 'ur' => 'Meta Ads'],
                            ['ar' => 'إدارة سوشيال ميديا', 'en' => 'Social media management', 'ur' => 'سوشل میڈیا'],
                            ['ar' => 'تحليل ROI', 'en' => 'ROI analysis', 'ur' => 'ROI تجزیہ'],
                        ],
                        'highlight' => true,
                    ],
                ],
            ],
        ];

        $iconMap = ['erp' => 'erp-systems', 'web' => 'websites', 'store' => 'e-commerce', 'marketing' => 'digital-marketing'];

        foreach ($iconMap as $icon => $slug) {
            $data = $services[$slug];
            Service::where('icon', $icon)->update([
                'slug' => $data['slug'],
                'body' => $data['body'],
                'offers' => $data['offers'],
            ]);
        }
    }
}
