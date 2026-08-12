<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Driver
    |--------------------------------------------------------------------------
    | moyasar — بوابة Moyasar الحقيقية (فيزا، مدى، Apple Pay، STC Pay)
    | sandbox — محاكاة للتطوير بدون مفاتيح
    */
    'driver' => env('PAYMENT_DRIVER', 'sandbox'),

    'currency' => env('PAYMENT_CURRENCY', 'SAR'),

    'moyasar' => [
        'publishable_key' => env('MOYASAR_PUBLISHABLE_KEY'),
        'secret_key' => env('MOYASAR_SECRET_KEY'),
        'webhook_secret' => env('MOYASAR_WEBHOOK_SECRET'),
        'api_url' => 'https://api.moyasar.com/v1',
    ],

    'methods' => [
        'creditcard' => [
            'label_ar' => 'فيزا / ماستركارد',
            'label_en' => 'Visa / Mastercard',
            'label_ur' => 'Visa / Mastercard',
            'icon' => 'visa',
        ],
        'mada' => [
            'label_ar' => 'مدى',
            'label_en' => 'Mada',
            'label_ur' => 'Mada',
            'icon' => 'mada',
        ],
        'applepay' => [
            'label_ar' => 'Apple Pay',
            'label_en' => 'Apple Pay',
            'label_ur' => 'Apple Pay',
            'icon' => 'applepay',
        ],
        'stcpay' => [
            'label_ar' => 'STC Pay',
            'label_en' => 'STC Pay',
            'label_ur' => 'STC Pay',
            'icon' => 'stcpay',
        ],
    ],
];
