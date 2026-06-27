<?php

namespace Database\Seeders;

use App\Models\NavLink;
use App\Models\Service;
use App\Models\Stat;
use App\Models\User;
use App\Models\WhyUsItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tract.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );

        $services = [
            [
                'icon' => 'erp', 'highlight' => true, 'sort_order' => 1,
                'title' => ['ar' => 'أنظمة ERP', 'en' => 'ERP Systems', 'ur' => 'ERP سسٹمز'],
                'description' => [
                    'ar' => 'متخصصون في نظام العقود الموحدة ومشاريع تسليم مفتاح — إدارة متكاملة للمقاولات والمشاريع من التخطيط حتى التسليم.',
                    'en' => 'Specialists in unified contract systems and turnkey projects — integrated management from planning to delivery.',
                    'ur' => 'متحد معاہدہ نظام اور ٹرن کی پروجیکٹس میں ماہر — منصوبہ بندی سے فراہمی تک مکمل انتظام۔',
                ],
                'features' => [
                    ['ar' => 'نظام العقود الموحدة', 'en' => 'Unified Contract System', 'ur' => 'متحد معاہدہ نظام'],
                    ['ar' => 'مشاريع تسليم مفتاح', 'en' => 'Turnkey Projects', 'ur' => 'ٹرن کی پروجیکٹس'],
                    ['ar' => 'لوحات تحكم ذكية', 'en' => 'Smart Dashboards', 'ur' => 'سمارٹ ڈیش بورڈز'],
                ],
            ],
            [
                'icon' => 'web', 'highlight' => false, 'sort_order' => 2,
                'title' => ['ar' => 'المواقع الإلكترونية', 'en' => 'Websites', 'ur' => 'ویب سائٹس'],
                'description' => [
                    'ar' => 'مواقع احترافية سريعة ومتجاوبة تعكس هوية علامتك التجارية وتحقق أهدافك الرقمية.',
                    'en' => 'Professional, fast, responsive websites that reflect your brand and achieve digital goals.',
                    'ur' => 'پیشہ ورانہ، تیز، ریسپانسیو ویب سائٹس جو آپ کے برانڈ کی عکاسی کرتی ہیں۔',
                ],
                'features' => [
                    ['ar' => 'SEO محسّن', 'en' => 'Optimized SEO', 'ur' => 'بہتر SEO'],
                    ['ar' => 'تصميم متجاوب', 'en' => 'Responsive Design', 'ur' => 'ریسپانسیو ڈیزائن'],
                    ['ar' => 'أداء عالي', 'en' => 'High Performance', 'ur' => 'اعلی کارکردگی'],
                ],
            ],
            [
                'icon' => 'store', 'highlight' => false, 'sort_order' => 3,
                'title' => ['ar' => 'المتاجر الإلكترونية', 'en' => 'E-Commerce', 'ur' => 'ای کامرس'],
                'description' => [
                    'ar' => 'متاجر e-commerce متكاملة مع بوابات دفع محلية، إدارة مخزون، وتحليلات مبيعات.',
                    'en' => 'Integrated e-commerce stores with local payment gateways, inventory, and sales analytics.',
                    'ur' => 'مقامی ادائیگی گیٹ ویز، انوینٹری اور سیلز اینالیٹکس کے ساتھ مکمل اسٹورز۔',
                ],
                'features' => [
                    ['ar' => 'بوابات دفع محلية', 'en' => 'Local Payment Gateways', 'ur' => 'مقامی ادائیگی گیٹ ویز'],
                    ['ar' => 'إدارة الطلبات', 'en' => 'Order Management', 'ur' => 'آرڈر مینجمنٹ'],
                    ['ar' => 'تطبيق جوال', 'en' => 'Mobile App', 'ur' => 'موبائل ایپ'],
                ],
            ],
            [
                'icon' => 'marketing', 'highlight' => false, 'sort_order' => 4,
                'title' => ['ar' => 'التسويق الإلكتروني', 'en' => 'Digital Marketing', 'ur' => 'ڈیجیٹل مارکیٹنگ'],
                'description' => [
                    'ar' => 'استراتيجيات تسويق رقمي مدروسة — SEO، إعلانات، سوشيال ميديا، وتحليل ROI.',
                    'en' => 'Strategic digital marketing — SEO, ads, social media, and ROI analysis.',
                    'ur' => 'اسٹریٹجک ڈیجیٹل مارکیٹنگ — SEO، اشتہارات، سوشل میڈیا اور ROI۔',
                ],
                'features' => [
                    ['ar' => 'حملات مدفوعة', 'en' => 'Paid Campaigns', 'ur' => 'ادا شدہ مہمات'],
                    ['ar' => 'محتوى تسويقي', 'en' => 'Marketing Content', 'ur' => 'مارکیٹنگ مواد'],
                    ['ar' => 'تحليل الأداء', 'en' => 'Performance Analytics', 'ur' => 'کارکردگی تجزیہ'],
                ],
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(
                ['icon' => $data['icon'], 'sort_order' => $data['sort_order']],
                array_merge($data, ['is_active' => true])
            );
        }

        $stats = [
            ['value' => '+50', 'sort_order' => 1, 'label' => ['ar' => 'مشروع منجز', 'en' => 'Completed Projects', 'ur' => 'مکمل منصوبے']],
            ['value' => '+30', 'sort_order' => 2, 'label' => ['ar' => 'عميل راضٍ', 'en' => 'Happy Clients', 'ur' => 'مطمئن کلائنٹس']],
            ['value' => '4', 'sort_order' => 3, 'label' => ['ar' => 'مجالات خدمة', 'en' => 'Service Areas', 'ur' => 'خدماتی شعبے']],
            ['value' => '100%', 'sort_order' => 4, 'label' => ['ar' => 'التزام بالمواعيد', 'en' => 'On-Time Delivery', 'ur' => 'وقت پر فراہمی']],
        ];

        foreach ($stats as $data) {
            Stat::updateOrCreate(['sort_order' => $data['sort_order']], array_merge($data, ['is_active' => true]));
        }

        $whyUs = [
            ['sort_order' => 1, 'title' => ['ar' => 'خبرة محلية', 'en' => 'Local Expertise', 'ur' => 'مقامی مہارت'], 'description' => ['ar' => 'فهم عميق للسوق المحلي والأنظمة والفوترة الإلكترونية.', 'en' => 'Deep understanding of local market, regulations, and e-invoicing.', 'ur' => 'مقامی مارکیٹ، ضوابط اور الیکٹرانک انوائسنگ کی گہری سمجھ۔']],
            ['sort_order' => 2, 'title' => ['ar' => 'شفافية كاملة', 'en' => 'Full Transparency', 'ur' => 'مکمل شفافیت'], 'description' => ['ar' => 'Track Every Step — نُطلعك على كل مرحلة من مشروعك مع تقارير دورية واضحة.', 'en' => 'Track Every Step — clear periodic reports at every project stage.', 'ur' => 'ہر مرحلے پر واضح رپورٹس — Track Every Step۔']],
            ['sort_order' => 3, 'title' => ['ar' => 'نتائج قابلة للقياس', 'en' => 'Measurable Results', 'ur' => 'قابل پیمائش نتائج'], 'description' => ['ar' => 'Control Every Result — نركز على مؤشرات الأداء والعائد على الاستثمار.', 'en' => 'Control Every Result — focus on KPIs and ROI.', 'ur' => 'KPIs اور ROI پر توجہ — Control Every Result۔']],
            ['sort_order' => 4, 'title' => ['ar' => 'دعم مستمر', 'en' => 'Ongoing Support', 'ur' => 'مسلسل سپورٹ'], 'description' => ['ar' => 'فريق دعم متاح لمساعدتك بعد الإطلاق مع صيانة وتحديثات دورية.', 'en' => 'Support team available after launch with maintenance and updates.', 'ur' => 'لانچ کے بعد دیکھ بھال اور اپڈیٹس کے ساتھ سپورٹ ٹیم۔']],
            ['sort_order' => 5, 'title' => ['ar' => 'تقنيات حديثة', 'en' => 'Modern Tech', 'ur' => 'جدید ٹیکنالوجی'], 'description' => ['ar' => 'Laravel، Vue.js، وأحدث أدوات التطوير لضمان أداء وأمان عاليين.', 'en' => 'Laravel, Vue.js, and latest tools for high performance and security.', 'ur' => 'Laravel، Vue.js اور جدید ٹولز اعلی کارکردگی اور سیکیورٹی کے لیے۔']],
            ['sort_order' => 6, 'title' => ['ar' => 'شركة موثوقة', 'en' => 'Trusted Company', 'ur' => 'قابل اعتماد کمپنی'], 'description' => ['ar' => 'مسجلة رسمياً بسجل تجاري وبطاقة ضريبية — تعامل آمن وموثق.', 'en' => 'Officially registered with commercial register and tax card.', 'ur' => 'تجارتی رجسٹر اور ٹیکس کارڈ کے ساتھ سرکاری طور پر رجسٹرڈ۔']],
        ];

        foreach ($whyUs as $data) {
            WhyUsItem::updateOrCreate(['sort_order' => $data['sort_order']], array_merge($data, ['is_active' => true]));
        }

        $navLinks = [
            ['href' => '#services', 'sort_order' => 1, 'label' => ['ar' => 'خدماتنا', 'en' => 'Services', 'ur' => 'خدمات']],
            ['href' => '#about', 'sort_order' => 2, 'label' => ['ar' => 'من نحن', 'en' => 'About', 'ur' => 'ہمارے بارے میں']],
            ['href' => '#why-us', 'sort_order' => 3, 'label' => ['ar' => 'لماذا تراكت', 'en' => 'Why Trakkt', 'ur' => 'کیوں Trakkt']],
            ['href' => '#reviews', 'sort_order' => 4, 'label' => ['ar' => 'آراء العملاء', 'en' => 'Reviews', 'ur' => 'کلائنٹس کی رائے']],
            ['href' => '/blog', 'sort_order' => 5, 'label' => ['ar' => 'المدونة', 'en' => 'Blog', 'ur' => 'بلاگ']],
            ['href' => '#contact', 'sort_order' => 6, 'label' => ['ar' => 'تواصل معنا', 'en' => 'Contact', 'ur' => 'رابطہ']],
        ];

        foreach ($navLinks as $data) {
            NavLink::updateOrCreate(['href' => $data['href']], array_merge($data, ['is_active' => true]));
        }
    }
}
