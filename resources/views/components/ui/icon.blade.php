@props(['name'])

@if ($name === 'chevron-left')
<svg {{ $attributes->merge(['class' => 'shrink-0 size-4']) }} xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
</svg>
@elseif ($name === 'chevron-right')
<svg {{ $attributes->merge(['class' => 'shrink-0 size-4']) }} xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M6.22 11.78a.75.75 0 0 1 0-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 1.06-1.06l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd" />
</svg>
@endif