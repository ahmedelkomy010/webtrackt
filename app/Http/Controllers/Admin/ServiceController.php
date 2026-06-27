<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $services = Service::orderBy('sort_order')->get();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Service::create($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.services.index')->with('success', 'تمت إضافة الخدمة بنجاح.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->validated($request, $service));
        $this->content->invalidate();

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        $this->content->invalidate();

        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة.');
    }

    protected function validated(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug,'.($service?->id ?? 'NULL')],
            'icon' => ['required', 'in:erp,web,store,marketing'],
            'highlight' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ur' => ['required', 'string', 'max:255'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'description_ur' => ['required', 'string'],
            'body_ar' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'body_ur' => ['nullable', 'string'],
            'features_ar' => ['required', 'string'],
            'features_en' => ['required', 'string'],
            'features_ur' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $data['slug'] ?? Service::generateSlug($data['title_en'], $service?->id);

        return [
            'slug' => $slug,
            'icon' => $data['icon'],
            'highlight' => $request->boolean('highlight'),
            'sort_order' => $data['sort_order'],
            'title' => ['ar' => $data['title_ar'], 'en' => $data['title_en'], 'ur' => $data['title_ur']],
            'description' => ['ar' => $data['description_ar'], 'en' => $data['description_en'], 'ur' => $data['description_ur']],
            'body' => ['ar' => $data['body_ar'] ?? '', 'en' => $data['body_en'] ?? '', 'ur' => $data['body_ur'] ?? ''],
            'features' => $this->buildFeatures($data['features_ar'], $data['features_en'], $data['features_ur']),
            'offers' => $this->buildOffers($request),
            'is_active' => $request->boolean('is_active', true),
        ];
    }

    protected function buildOffers(Request $request): array
    {
        $offers = [];

        for ($i = 1; $i <= 3; $i++) {
            $nameAr = $request->input("offer_{$i}_name_ar");
            if (! $nameAr) {
                continue;
            }

            $offers[] = [
                'name' => [
                    'ar' => $nameAr,
                    'en' => $request->input("offer_{$i}_name_en", $nameAr),
                    'ur' => $request->input("offer_{$i}_name_ur", $nameAr),
                ],
                'price' => [
                    'ar' => $request->input("offer_{$i}_price_ar", ''),
                    'en' => $request->input("offer_{$i}_price_en", ''),
                    'ur' => $request->input("offer_{$i}_price_ur", ''),
                ],
                'features' => $this->buildFeatures(
                    $request->input("offer_{$i}_features_ar", ''),
                    $request->input("offer_{$i}_features_en", ''),
                    $request->input("offer_{$i}_features_ur", '')
                ),
                'highlight' => $request->boolean("offer_{$i}_highlight"),
            ];
        }

        return $offers;
    }

    protected function splitLines(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text))));
    }

    protected function buildFeatures(string $ar, string $en, string $ur): array
    {
        $linesAr = $this->splitLines($ar);
        $linesEn = $this->splitLines($en);
        $linesUr = $this->splitLines($ur);
        $count = max(count($linesAr), count($linesEn), count($linesUr));
        $features = [];

        for ($i = 0; $i < $count; $i++) {
            $features[] = [
                'ar' => $linesAr[$i] ?? '',
                'en' => $linesEn[$i] ?? '',
                'ur' => $linesUr[$i] ?? '',
            ];
        }

        return $features;
    }
}
