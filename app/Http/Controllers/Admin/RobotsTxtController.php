<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RobotsTxtService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RobotsTxtController extends Controller
{
    public function __construct(protected RobotsTxtService $robots) {}

    public function edit(): View
    {
        return view('admin.robots.edit', [
            'exists' => $this->robots->exists(),
            'content' => $this->robots->read() ?? $this->robots->defaultContent(),
            'defaultContent' => $this->robots->defaultContent(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:65535'],
        ]);

        $this->robots->save($data['content']);

        return redirect()->route('admin.robots.edit')->with('success', 'تم حفظ ملف robots.txt بنجاح.');
    }

    public function destroy(): RedirectResponse
    {
        if (! $this->robots->delete()) {
            return redirect()->route('admin.robots.edit')->with('success', 'الملف غير موجود.');
        }

        return redirect()->route('admin.robots.edit')->with('success', 'تم حذف ملف robots.txt.');
    }
}
