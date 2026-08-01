<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSettingsController extends Controller
{
    public function __construct(protected ContactSettingsService $contact) {}

    public function edit(): View
    {
        $settings = $this->contact->all();

        return view('admin.contact.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone'          => ['nullable', 'string', 'max:20'],
            'phone_intl'     => ['nullable', 'string', 'max:25'],
            'whatsapp'       => ['nullable', 'string', 'max:25'],
            'email'          => ['nullable', 'email', 'max:100'],
            'twitter_url'    => ['nullable', 'url', 'max:255'],
            'instagram_url'  => ['nullable', 'url', 'max:255'],
            'facebook_url'   => ['nullable', 'url', 'max:255'],
            'snapchat_url'   => ['nullable', 'url', 'max:255'],
            'linkedin_url'   => ['nullable', 'url', 'max:255'],
            'tiktok_url'     => ['nullable', 'url', 'max:255'],
        ]);

        $this->contact->save(array_map(fn ($v) => $v ?? '', $data));

        return redirect()->route('admin.contact.edit')
            ->with('success', 'تم حفظ إعدادات التواصل بنجاح.');
    }
}
