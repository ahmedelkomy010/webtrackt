<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AboutSettingsService;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutSettingsController extends Controller
{
    public function __construct(
        protected AboutSettingsService $about,
        protected ContentService $content
    ) {}

    public function edit(): View
    {
        return view('admin.about.edit', [
            'settings' => $this->about->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'hero_side_image_file' => ['nullable', 'image', 'max:4096'],
            'about_image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        $data = $this->about->all();

        if ($request->hasFile('hero_side_image_file')) {
            if (! empty($data['hero_side_image'])) {
                Storage::disk('public')->delete($data['hero_side_image']);
            }
            $data['hero_side_image'] = $request->file('hero_side_image_file')->store('about', 'public');
        }

        if ($request->hasFile('about_image_file')) {
            foreach (['about_image', 'middle_image', 'marketing_image'] as $key) {
                if (! empty($data[$key])) {
                    Storage::disk('public')->delete($data[$key]);
                }
            }
            $data['about_image'] = $request->file('about_image_file')->store('about', 'public');
        }

        $this->about->save($data);
        $this->content->invalidate();

        return redirect()->route('admin.about.edit')
            ->with('success', 'تم حفظ الصور بنجاح.');
    }
}
