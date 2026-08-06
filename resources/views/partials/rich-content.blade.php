@php
    use App\Support\RichContent;

    $html = RichContent::format($content ?? '');
    $dir = $dir ?? (in_array($locale ?? app()->getLocale(), ['ar', 'ur'], true) ? 'rtl' : 'ltr');
@endphp

@if ($html)
<div class="rich-content{{ ($variant ?? '') === 'light' ? ' rich-content--light' : '' }}" dir="{{ $dir }}">
    {!! $html !!}
</div>
@endif
