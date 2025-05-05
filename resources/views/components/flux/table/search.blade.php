@props([
    'variable' => 'search',
    'placeholder' => 'search_placeholder'
])

<div class="mb-4">
    <div class="relative w-full max-w-sm">
        <input 
            type="text"
            wire:model.live="{{ $variable }}"
            placeholder="{{ __($placeholder) }}"
            class="w-full pl-10 pr-4 py-2 text-sm rounded-xl bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white border border-zinc-300 dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150"
        >
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
            </svg>
        </div>
    </div>
</div>