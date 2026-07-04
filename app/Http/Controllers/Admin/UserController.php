<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => new User()]);
    }

    public function store(Request $request): RedirectResponse
    {
        User::create($this->validated($request));

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المشرف بنجاح.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($this->validated($request, $user));

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المشرف.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['user' => 'لا يمكنك حذف حسابك الحالي.']);
        }

        if (User::count() <= 1) {
            return back()->withErrors(['user' => 'يجب أن يبقى مشرف واحد على الأقل.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المشرف.');
    }

    public function profile(): View
    {
        return view('admin.profile.edit', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->update($this->validated($request, $user, true));

        return redirect()->route('admin.profile.edit')->with('success', 'تم تحديث حسابك بنجاح.');
    }

    protected function validated(Request $request, ?User $user = null, bool $isProfile = false): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::min(8)],
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        return $payload;
    }
}
