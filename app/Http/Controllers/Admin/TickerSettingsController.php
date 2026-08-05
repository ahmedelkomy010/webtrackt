<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TickerSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TickerSettingsController extends Controller
{
    public function __construct(protected TickerSettingsService $ticker) {}

    public function edit(): View
    {
        return view('admin.ticker.edit', [
            'settings' => $this->ticker->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'messages_ar' => ['nullable', 'string'],
            'messages_en' => ['nullable', 'string'],
            'messages_ur' => ['nullable', 'string'],
        ]);

        $this->ticker->save([
            'enabled' => $request->boolean('enabled'),
            'messages_ar' => $this->splitLines($data['messages_ar'] ?? ''),
            'messages_en' => $this->splitLines($data['messages_en'] ?? ''),
            'messages_ur' => $this->splitLines($data['messages_ur'] ?? ''),
        ]);

        return redirect()->route('admin.ticker.edit')->with('success', 'تم حفظ الشريط المتحرك بنجاح.');
    }

    protected function splitLines(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text))));
    }
}
