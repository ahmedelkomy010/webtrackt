<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use App\Services\ContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatController extends Controller
{
    public function __construct(protected ContentService $content) {}

    public function index(): View
    {
        $stats = Stat::orderBy('sort_order')->get();

        return view('admin.stats.index', compact('stats'));
    }

    public function create(): View
    {
        return view('admin.stats.form', ['stat' => new Stat()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Stat::create($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.stats.index')->with('success', 'تمت إضافة الإحصائية.');
    }

    public function edit(Stat $stat): View
    {
        return view('admin.stats.form', compact('stat'));
    }

    public function update(Request $request, Stat $stat): RedirectResponse
    {
        $stat->update($this->validated($request));
        $this->content->invalidate();

        return redirect()->route('admin.stats.index')->with('success', 'تم تحديث الإحصائية.');
    }

    public function destroy(Stat $stat): RedirectResponse
    {
        $stat->delete();
        $this->content->invalidate();

        return redirect()->route('admin.stats.index')->with('success', 'تم حذف الإحصائية.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'value' => ['required', 'string', 'max:50'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'label_ar' => ['required', 'string', 'max:255'],
            'label_en' => ['required', 'string', 'max:255'],
            'label_ur' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'value' => $data['value'],
            'sort_order' => $data['sort_order'],
            'label' => ['ar' => $data['label_ar'], 'en' => $data['label_en'], 'ur' => $data['label_ur']],
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
