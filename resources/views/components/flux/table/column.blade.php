{{-- <th
    {{ $attributes->merge(['class' => 'px-6 py-3 text-left font-medium cursor-pointer select-none hover:text-primary-600']) }}
>
    {{ $slot }}

    @if (isset($sortField) && $sortField === $field)
        @if ($sortDirection === 'asc')
            ▲
        @else
            ▼
        @endif
    @endif
</th> --}}
<th class="px-6 py-3 text-left font-medium">
    {{ $slot }}
</th>