@extends('layouts.admin')

@section('title', 'صور الموقع')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">صور الموقع</h1>
    <p class="text-slate-600 text-sm mt-1">صورتين فقط — Hero و «من نحن»</p>
</div>

@if ($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-800 border border-red-200">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (session('success'))
    <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-800 border border-green-200">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-6">
        <div>
            <label class="block text-sm font-medium mb-2">صورة Hero — يمين الصفحة الرئيسية</label>
            @if ($settings['hero_side_image'] ?? null)
                <img src="{{ asset('storage/'.$settings['hero_side_image']) }}" alt="Hero" class="w-full max-w-md h-48 object-cover rounded-xl mb-3 border">
            @endif
            <input type="file" name="hero_side_image_file" accept="image/*" class="w-full text-sm">
            <p class="text-xs text-slate-500 mt-1">مقاس مقترح: 600×700 بكسل</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">صورة قسم «من نحن»</label>
            @if ($settings['about_image'] ?? null)
                <img src="{{ asset('storage/'.$settings['about_image']) }}" alt="About" class="w-full max-w-md h-48 object-cover rounded-xl mb-3 border">
            @endif
            <input type="file" name="about_image_file" accept="image/*" class="w-full text-sm">
            <p class="text-xs text-slate-500 mt-1">مقاس مقترح: 800×500 بكسل</p>
        </div>
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-tract-600 text-white font-semibold hover:bg-tract-700">
        حفظ الصور
    </button>
</form>
@endsection
