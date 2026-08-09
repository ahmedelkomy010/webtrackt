<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessPartner;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SuccessPartnerController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $partners = SuccessPartner::orderBy('sort_order')->get();

        return view('admin.success-partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.success-partners.form', ['partner' => new SuccessPartner()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['logo'] = $this->storeLogo($request);
        SuccessPartner::create($data);
        $this->content->invalidate();

        return redirect()->route('admin.success-partners.index')->with('success', 'تمت إضافة الشريك.');
    }

    public function edit(SuccessPartner $success_partner): View
    {
        return view('admin.success-partners.form', ['partner' => $success_partner]);
    }

    public function update(Request $request, SuccessPartner $success_partner): RedirectResponse
    {
        $data = $this->validated($request, $success_partner);

        if ($request->hasFile('logo_file')) {
            if ($success_partner->logo) {
                Storage::disk('public')->delete($success_partner->logo);
            }
            $data['logo'] = $this->storeLogo($request);
        }

        $success_partner->update($data);
        $this->content->invalidate();

        return redirect()->route('admin.success-partners.index')->with('success', 'تم تحديث الشريك.');
    }

    public function destroy(SuccessPartner $success_partner): RedirectResponse
    {
        if ($success_partner->logo) {
            Storage::disk('public')->delete($success_partner->logo);
        }

        $success_partner->delete();
        $this->content->invalidate();

        return redirect()->route('admin.success-partners.index')->with('success', 'تم حذف الشريك.');
    }

    protected function validated(Request $request, ?SuccessPartner $partner = null): array
    {
        $data = $request->validate([
            'logo_file' => [$partner ? 'nullable' : 'required', 'image', 'max:2048'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'name_ur' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'name' => [
                'ar' => $data['name_ar'] ?? '',
                'en' => $data['name_en'] ?? '',
                'ur' => $data['name_ur'] ?? '',
            ],
            'url' => $data['url'] ?? null,
            'sort_order' => $data['sort_order'],
            'is_active' => $request->boolean('is_active', true),
        ];
    }

    protected function storeLogo(Request $request): string
    {
        return $request->file('logo_file')->store('partners', 'public');
    }
}
