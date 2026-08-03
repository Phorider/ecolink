@props(['disabled' => false])
<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm']) }}>
