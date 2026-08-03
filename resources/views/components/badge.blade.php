@props(['color' => 'bg-gray-100 text-gray-800'])
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold $color"]) }}>
    {{ $slot }}
</span>
