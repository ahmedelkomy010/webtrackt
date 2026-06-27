<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'أحمد الشمري',
                'company' => 'شركة بناء الخليج',
                'rating' => 5,
                'sort_order' => 1,
                'is_featured' => true,
                'comment' => [
                    'ar' => 'تعاملنا مع تراكت في نظام ERP للعقود الموحدة وكانت تجربة ممتازة. فريق محترف، التزام بالمواعيد، ودعم مستمر بعد التسليم.',
                    'en' => 'We worked with Trakkt on an ERP unified contract system — excellent experience. Professional team, on-time delivery, and ongoing support.',
                    'ur' => 'Trakkt کے ساتھ ERP نظام پر کام کیا — بہترین تجربہ۔ پیشہ ور ٹیم اور وقت پر فراہمی۔',
                ],
            ],
            [
                'name' => 'سارة العتيبي',
                'company' => 'متجر نور الإلكتروني',
                'rating' => 5,
                'sort_order' => 2,
                'is_featured' => false,
                'comment' => [
                    'ar' => 'متجرنا الإلكتروني أصبح أسرع وأجمل بفضل تراكت. المبيعات زادت 40% خلال 3 أشهر من الإطلاق.',
                    'en' => 'Our e-commerce store became faster and better thanks to Trakkt. Sales increased 40% within 3 months of launch.',
                    'ur' => 'Trakkt کی وجہ سے ہمارا اسٹور تیز اور بہتر ہوا۔ 3 ماہ میں فروخت 40% بڑھی۔',
                ],
            ],
            [
                'name' => 'Mohammed Al-Rashid',
                'company' => 'Gulf Contracting Co.',
                'rating' => 4,
                'sort_order' => 3,
                'is_featured' => false,
                'comment' => [
                    'ar' => 'خدمة تسويق إلكتروني ممتازة. ظهرنا في Google خلال شهرين ووصلنا عملاء جدد باستمرار.',
                    'en' => 'Excellent digital marketing service. We appeared on Google within two months and keep getting new clients.',
                    'ur' => 'بہترین ڈیجیٹل مارکیٹنگ۔ دو ماہ میں Google پر نظر آئے۔',
                ],
            ],
        ];

        foreach ($reviews as $data) {
            Review::updateOrCreate(
                ['name' => $data['name'], 'company' => $data['company']],
                array_merge($data, ['is_approved' => true])
            );
        }
    }
}
