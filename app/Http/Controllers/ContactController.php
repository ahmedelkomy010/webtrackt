<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'service' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'phone.required' => 'رقم الجوال مطلوب.',
            'service.required' => 'يرجى اختيار الخدمة.',
            'message.required' => 'تفاصيل المشروع مطلوبة.',
        ]);

        ContactMessage::create($validated);

        return response()->json([
            'message' => 'تم إرسال رسالتك بنجاح.',
        ], 201);
    }
}
