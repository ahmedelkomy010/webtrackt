<?php

namespace Database\Seeders;

use App\Models\NavLink;
use App\Models\Post;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        NavLink::updateOrCreate(
            ['href' => '/blog'],
            [
                'sort_order' => 5,
                'label' => ['ar' => 'المدونة', 'en' => 'Blog', 'ur' => 'بلاگ'],
                'is_active' => true,
            ]
        );

        $posts = [
            [
                'slug' => 'erp-system-unified-contract-saudi-arabia',
                'title' => [
                    'ar' => 'نظام ERP للعقد الموحد في السعودية — دليل شامل 2025',
                    'en' => 'ERP System for Unified Contracts in Saudi Arabia — Complete Guide 2025',
                    'ur' => 'سعودی عرب میں متحد معاہدے کے لیے ERP نظام — مکمل گائیڈ 2025',
                ],
                'excerpt' => [
                    'ar' => 'اكتشف كيف يساعد نظام ERP المتخصص في العقد الموحد شركات المقاولات في السعودية على إدارة المشاريع بكفاءة والالتزام بمتطلبات ZATCA.',
                    'en' => 'Discover how specialized ERP unified contract systems help contracting companies in Saudi Arabia manage projects efficiently and comply with ZATCA requirements.',
                    'ur' => 'جانیں کہ خصوصی ERP متحد معاہدہ نظام سعودی عرب میں تعمیراتی کمپنیوں کو منصوبوں کا مؤثر انتظام کرنے میں کیسے مدد کرتا ہے۔',
                ],
                'content' => [
                    'ar' => '<h2>ما هو نظام العقد الموحد؟</h2><p>نظام العقد الموحد هو إطار تنظيمي يُستخدم في قطاع المقاولات والبناء في المملكة العربية السعودية لتوحيد شروط العقود بين جميع الأطراف. مع التحول الرقمي وتوجه رؤية 2030، أصبحت أنظمة <strong>ERP</strong> ضرورة حتمية لإدارة هذه العقود بكفاءة.</p><h2>فوائد ERP للمقاولات</h2><ul><li>إدارة متكاملة للمشاريع من التخطيط حتى التسليم</li><li>تتبع التكاليف والميزانيات في الوقت الفعلي</li><li>التوافق مع الفوترة الإلكترونية ZATCA</li><li>لوحات تحكم ذكية لاتخاذ القرارات</li></ul><h2>لماذا تراكت؟</h2><p>تراكت <strong>Trackkt.com</strong> — أول نظام مقاولات متخصص في العقد الموحد. نقدم حلول ERP مخصصة للسوق السعودي والخليجي مع دعم محلي كامل.</p>',
                    'en' => '<h2>What is the Unified Contract System?</h2><p>The unified contract system is a regulatory framework used in Saudi Arabia\'s construction sector. With Vision 2030 digital transformation, <strong>ERP systems</strong> are essential for efficient contract management.</p><h2>ERP Benefits for Contracting</h2><ul><li>Integrated project management from planning to delivery</li><li>Real-time cost and budget tracking</li><li>ZATCA e-invoicing compliance</li><li>Smart dashboards for decision making</li></ul><h2>Why Trackkt?</h2><p>Trackkt <strong>Trackkt.com</strong> — the first contracting system specialized in unified contracts for Saudi Arabia and GCC.</p>',
                    'ur' => '<h2>متحد معاہدہ نظام کیا ہے؟</h2><p>متحد معاہدہ نظام سعودی عرب میں تعمیراتی شعبے میں استعمال ہونے والا ایک ضابطہ ہے۔ <strong>ERP نظام</strong> مؤثر انتظام کے لیے ضروری ہیں۔</p><h2>Trackkt کیوں؟</h2><p>Trackkt <strong>Trackkt.com</strong> — متحد معاہدوں میں مہارت رکھنے والا پہلا نظام۔</p>',
                ],
                'meta_title' => [
                    'ar' => 'نظام ERP العقد الموحد السعودية | تراكت Trackkt',
                    'en' => 'ERP Unified Contract System Saudi Arabia | Trackkt',
                    'ur' => 'ERP متحد معاہدہ سعودی عرب | Trackkt',
                ],
                'meta_description' => [
                    'ar' => 'دليل شامل لنظام ERP والعقد الموحد في السعودية. تراكت Trackkt — حلول ERP للمقاولات، ZATCA، إدارة مشاريع تسليم مفتاح.',
                    'en' => 'Complete guide to ERP and unified contracts in Saudi Arabia. Trackkt Trackkt — ERP solutions for contracting and turnkey projects.',
                    'ur' => 'سعودی عرب میں ERP اور متحد معاہدوں کی مکمل گائیڈ۔ Trackkt Trackkt۔',
                ],
                'meta_keywords' => [
                    'ar' => 'ERP السعودية, نظام العقد الموحد, ERP مقاولات, تراكت, Trackkt, ZATCA, فوترة إلكترونية, إدارة مشاريع, تسليم مفتاح, نظام ERP, الرياض, مقاولات السعودية',
                    'en' => 'ERP Saudi Arabia, unified contract, contracting ERP, Trackkt, Trackkt, ZATCA, project management, turnkey',
                    'ur' => 'ERP سعودی عرب, متحد معاہدہ, Trackkt, Trackkt, ZATCA',
                ],
            ],
            [
                'slug' => 'digital-marketing-seo-saudi-businesses',
                'title' => [
                    'ar' => 'التسويق الإلكتروني وSEO للشركات السعودية — استراتيجيات 2025',
                    'en' => 'Digital Marketing & SEO for Saudi Businesses — 2025 Strategies',
                    'ur' => 'سعودی کاروبار کے لیے ڈیجیٹل مارکیٹنگ اور SEO — 2025 حکمت عملی',
                ],
                'excerpt' => [
                    'ar' => 'تعلّم أفضل استراتيجيات التسويق الإلكتروني وتحسين محركات البحث Google لزيادة ظهور شركتك في السعودية والخليج.',
                    'en' => 'Learn the best digital marketing and Google SEO strategies to increase your company visibility in Saudi Arabia and GCC.',
                    'ur' => 'سعودی عرب اور خلیج میں اپنی کمپنی کی مرئیت بڑھانے کے لیے بہترین ڈیجیٹل مارکیٹنگ اور SEO حکمت عملی سیکھیں۔',
                ],
                'content' => [
                    'ar' => '<h2>لماذا SEO مهم للشركات السعودية؟</h2><p>مع تزايد البحث على Google في المملكة، أصبح <strong>تحسين محركات البحث SEO</strong> أهم استثمار تسويقي. أكثر من 90% من تجارب البحث تبدأ على Google.</p><h2>استرategias فعّالة</h2><ul><li>كلمات مفتاحية محلية (السعودية، الرياض، جدة)</li><li>محتوى عربي أصلي عالي الجودة</li><li>تحسين Core Web Vitals وسرعة الموقع</li><li>Schema markup و JSON-LD</li><li>Google Search Console و Analytics</li></ul><h2>خدمات تراكت التسويقية</h2><p>نقدم في <strong>تراكت</strong> حملات SEO مدروسة، إعلانات Google و Meta، وتحليل ROI قابل للقياس. تواصل معنا على Trackkt.com</p>',
                    'en' => '<h2>Why SEO Matters in Saudi Arabia</h2><p>With growing Google searches in the Kingdom, <strong>SEO</strong> is the most important marketing investment. Over 90% of search experiences start on Google.</p><h2>Effective Strategies</h2><ul><li>Local keywords (Saudi Arabia, Riyadh, Jeddah)</li><li>High-quality Arabic content</li><li>Core Web Vitals optimization</li><li>Schema markup and JSON-LD</li></ul><h2>Trackkt Marketing Services</h2><p>Trackkt offers strategic SEO campaigns, Google & Meta ads, and measurable ROI analysis at Trackkt.com</p>',
                    'ur' => '<h2>سعودی عرب میں SEO کیوں اہم ہے؟</h2><p>Google تلاش بڑھنے کے ساتھ <strong>SEO</strong> سب سے اہم مارکیٹنگ سرمایہ کاری ہے۔</p><h2>Trackkt مارکیٹنگ خدمات</h2><p>Trackkt Trackkt.com پر SEO مہمات اور ROI تجزیہ پیش کرتا ہے۔</p>',
                ],
                'meta_title' => [
                    'ar' => 'تسويق إلكتروني SEO السعودية | Google | تراكت',
                    'en' => 'Digital Marketing SEO Saudi Arabia | Google | Trackkt',
                    'ur' => 'ڈیجیٹل مارکیٹنگ SEO سعودی عرب | Trackkt',
                ],
                'meta_description' => [
                    'ar' => 'استراتيجيات التسويق الإلكتروني وSEO للشركات السعودية. تحسين ظهورك على Google مع تراكت — Trackkt.com',
                    'en' => 'Digital marketing and SEO strategies for Saudi businesses. Improve your Google visibility with Trackkt — Trackkt.com',
                    'ur' => 'سعودی کاروبار کے لیے SEO حکمت عملی۔ Trackkt — Trackkt.com',
                ],
                'meta_keywords' => [
                    'ar' => 'تسويق إلكتروني, SEO السعودية, تحسين محركات البحث, Google SEO, تسويق رقمي, تراكت, Trackkt, إعلانات Google, السعودية, الرياض, شركة تسويق',
                    'en' => 'digital marketing, SEO Saudi Arabia, Google SEO, Trackkt, Trackkt, Google ads',
                    'ur' => 'ڈیجیٹل مارکیٹنگ, SEO, Google, Trackkt, Trackkt',
                ],
            ],
            [
                'slug' => 'ecommerce-website-development-saudi-gcc',
                'title' => [
                    'ar' => 'تطوير متاجر إلكترونية ومواقع احترافية في السعودية والخليج',
                    'en' => 'E-Commerce & Professional Website Development in Saudi & GCC',
                    'ur' => 'سعودی عرب اور خلیج میں ای کامرس اور ویب سائٹ ڈvelopment',
                ],
                'excerpt' => [
                    'ar' => 'دليل شامل لتطوير متاجر e-commerce ومواقع احترافية مع بوابات دفع محلية وSEO محسّن للسوق السعودي.',
                    'en' => 'Complete guide to e-commerce stores and professional websites with local payment gateways and SEO for the Saudi market.',
                    'ur' => 'مقامی ادائیگی گیٹ ویز اور SEO کے ساتھ ای کامرس اسٹورز کی مکمل گائیڈ۔',
                ],
                'content' => [
                    'ar' => '<h2>متجرك الإلكتروني = واجهة عملك الرقمية</h2><p>في 2025، لا يمكن لأي شركة النجاح بدون حضور رقمي قوي. سواء كنت تحتاج <strong>موقع إلكتروني</strong> أو <strong>متجر e-commerce</strong>، الجودة والسرعة والSEO هم مفاتيح النجاح.</p><h2>مميزات متجر تراكت</h2><ul><li>بوابات دفع محلية (Mada, Apple Pay, STC Pay)</li><li>تصميم متجاوب Mobile-first</li><li>SEO محسّن من اليوم الأول</li><li>إدارة مخزون وطلبات متكاملة</li><li>أداء عالي Core Web Vitals</li></ul><h2>ابدأ مشروعك</h2><p>تواصل مع <strong>تراكت Trackkt.com</strong> — فريقنا جاهز لبناء موقع أو متجر يحقق أهدافك.</p>',
                    'en' => '<h2>Your E-Store = Your Digital Front</h2><p>In 2025, no company succeeds without a strong digital presence. Whether you need a <strong>website</strong> or <strong>e-commerce store</strong>, quality, speed, and SEO are key.</p><h2>Trackkt Store Features</h2><ul><li>Local payment gateways (Mada, Apple Pay, STC Pay)</li><li>Mobile-first responsive design</li><li>SEO optimized from day one</li><li>Integrated inventory and order management</li></ul><p>Contact <strong>Trackkt Trackkt.com</strong> to start your project.</p>',
                    'ur' => '<h2>آپ کا ای اسٹور = آپ کی ڈیجیٹل واجہہ</h2><p>2025 میں مضبوط ڈیجیٹل موجودگی ضروری ہے۔</p><p><strong>Trackkt Trackkt.com</strong> سے رابطہ کریں۔</p>',
                ],
                'meta_title' => [
                    'ar' => 'متجر إلكتروني وموقع احترافي | السعودية | تراكت',
                    'en' => 'E-Commerce Store & Website | Saudi Arabia | Trackkt',
                    'ur' => 'ای کامرس اسٹور | سعودی عرب | Trackkt',
                ],
                'meta_description' => [
                    'ar' => 'تطوير متاجر إلكترونية ومواقع احترافية في السعودية. بوابات دفع محلية، SEO، أداء عالي — تراكت Trackkt.com',
                    'en' => 'E-commerce and website development in Saudi Arabia. Local payments, SEO, high performance — Trackkt Trackkt.com',
                    'ur' => 'سعودی عرب میں ای کامرس ڈvelopment۔ Trackkt Trackkt.com',
                ],
                'meta_keywords' => [
                    'ar' => 'متجر إلكتروني, موقع إلكتروني, e-commerce السعودية, تطوير مواقع, برمجة مواقع, تراكت, Trackkt, Mada, STC Pay, SEO, متجر سعودي',
                    'en' => 'e-commerce, website development, Saudi Arabia, Trackkt, Trackkt, Mada, SEO',
                    'ur' => 'ای کامرس, ویب سائٹ, Trackkt, Trackkt, SEO',
                ],
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'is_published' => true,
                    'published_at' => now()->subDays(rand(1, 30)),
                ])
            );
        }
    }
}
