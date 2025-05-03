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
<th scope="col" class="py-3 px-3 text-start text-sm font-medium text-zinc-800 dark:text-white uppercase" data-flux-column="">
    <div class="flex">
        {{ $slot }}
    </div>
</th>