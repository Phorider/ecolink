@props(['messages'])
@if ($messages)
    <p {{ $attributes->merge(['class' => 'mt-1 text-sm text-red-600']) }}>
        {{ (is_array($messages) || $messages instanceof \Illuminate\Support\MessageBag) ? implode(' ', is_array($messages) ? $messages : $messages->all()) : $messages }}
    </p>
@endif
