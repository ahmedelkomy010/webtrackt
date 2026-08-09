<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $works = Work::orderBy('sort_order')->get();

        return view('admin.works.index', compact('works'));
    }

    public function create(): View
    {
        return view('admin.works.form', ['work' => new Work()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeImage($request);
        Work::create($data);
        $this->content->invalidate();

        return redirect()->route('admin.works.index')->with('success', 'تمت إضافة العمل.');
    }

    public function edit(Work $work): View
    {
        return view('admin.works.form', compact('work'));
    }

    public function update(Request $request, Work $work): RedirectResponse
    {
        $data = $this->validated($request, $work);

        if ($request->hasFile('image_file')) {
            if ($work->image) {
                Storage::disk('public')->delete($work->image);
            }
            $data['image'] = $this->storeImage($request);
        }

        $work->update($data);
        $this->content->invalidate();

        return redirect()->route('admin.works.index')->with('success', 'تم تحديث العمل.');
    }

    public function destroy(Work $work): RedirectResponse
    {
        if ($work->image) {
            Storage::disk('public')->delete($work->image);
        }

        $work->delete();
        $this->content->invalidate();

        return redirect()->route('admin.works.index')->with('success', 'تم حذف العمل.');
    }

    protected function validated(Request $request, ?Work $work = null): array
    {
        $data = $request->validate([
            'image_file' => [$work ? 'nullable' : 'required', 'image', 'max:4096'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_ur' => ['required', 'string', 'max:255'],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'description_ur' => ['required', 'string'],
            'url' => ['required', 'url', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'title' => [
                'ar' => $data['title_ar'],
                'en' => $data['title_en'],
                'ur' => $data['title_ur'],
            ],
            'description' => [
                'ar' => $data['description_ar'],
                'en' => $data['description_en'],
                'ur' => $data['description_ur'],
            ],
            'url' => $data['url'],
            'sort_order' => $data['sort_order'],
            'is_active' => $request->boolean('is_active', true),
        ];
    }

    protected function storeImage(Request $request): string
    {
        return $request->file('image_file')->store('works', 'public');
    }
}
