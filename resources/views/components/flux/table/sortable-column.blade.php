@props(['field', 'label', 'sortField', 'sortDirection'])

@php
    $isCurrent = $field === $sortField;
    $directionIcon = $isCurrent
        ? ($sortDirection === 'asc' ? '▲' : '▼')
        : '⇅';
@endphp

<th
    scope="col"
    class="cursor-pointer py-3 px-3 text-start text-sm font-medium text-zinc-800 dark:text-white uppercase"
    wire:click="sortBy('{{ $field }}')"
>
    <div class="flex items-center space-x-1">
        <span>{{ __($label) }}</span>
        <span class="text-[10px]">{{ $directionIcon }}</span>
    </div>
</th>