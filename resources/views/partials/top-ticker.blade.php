@php
    use App\Services\TickerSettingsService;
    use App\Support\Locale;

    $ticker = app(TickerSettingsService::class)->all();
    $loc = $locale ?? Locale::AR;
    $messages = $ticker['messages_'.$loc] ?? $ticker['messages_ar'] ?? [];
    $messages = array_values(array_filter(is_array($messages) ? $messages : []));
@endphp

@if (($ticker['enabled'] ?? true) && count($messages))
<div class="top-ticker safe-top" dir="{{ Locale::dir($loc) }}">
    <div class="top-ticker__viewport">
        <div class="top-ticker__track">
            @foreach (array_merge($messages, $messages) as $message)
                <span class="top-ticker__item">{{ $message }}</span>
            @endforeach
        </div>
    </div>
</div>
@endif
