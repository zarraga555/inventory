@props(['paginator'])

@if ($paginator->hasPages())
    <div class="pt-3 border-t border-zinc-100 dark:border-zinc-700 flex justify-between items-center gap-3"
        data-flux-pagination="">
        <div class="text-zinc-500 dark:text-zinc-400 text-sm font-medium whitespace-nowrap">
            {{ __('Showing') }} {{ $paginator->firstItem() }} {{ __('to') }} {{ $paginator->lastItem() }}
            {{ __('of') }} {{ $paginator->total() }} {{ __('results') }}
        </div>

        <!-- Paginación móvil -->
        <div
            class="flex sm:hidden items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
            @if ($paginator->previousPageUrl())
                <button wire:click="previousPage"
                    class="flex justify-center items-center size-10 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white"
                    aria-label="« Previous">
                    <x-ui.icon name="chevron-left" class="shrink-0 size-5" />
                </button>
            @else
                <span class="flex justify-center items-center size-10 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                    <x-ui.icon name="chevron-left" class="shrink-0 size-5" />
                </span>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage"
                    class="flex justify-center items-center size-10 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white"
                    aria-label="Next »">
                    <x-ui.icon name="chevron-right" class="shrink-0 size-5" />
                </button>
            @else
                <span class="flex justify-center items-center size-10 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                    <x-ui.icon name="chevron-right" class="shrink-0 size-5" />
                </span>
            @endif
        </div>

        <!-- Paginación escritorio -->
        <div
            class="hidden sm:flex items-center bg-white border border-zinc-200 rounded-[8px] p-[1px] dark:bg-white/10 dark:border-white/10">
            @if ($paginator->previousPageUrl())
                <button wire:click="previousPage"
                    class="flex justify-center items-center size-8 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white"
                    aria-label="« Previous">
                    <x-ui.icon name="chevron-left" class="shrink-0 size-5" />
                </button>
            @else
                <span class="flex justify-center items-center size-8 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                    <x-ui.icon name="chevron-left" class="shrink-0 size-5" />
                </span>
            @endif

            <!-- Páginas -->
            @foreach ($paginator->links()->elements[0] as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span
                        class="flex justify-center items-center size-8 rounded-[6px] bg-primary text-primary-foreground text-base font-medium">{{ $page }}</span>
                @else
                    <button wire:click="gotoPage({{ $page }})"
                        class="flex justify-center items-center size-8 rounded-[6px] hover:bg-zinc-100 dark:hover:bg-white/20 text-zinc-400 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white text-base">
                        {{ $page }}
                    </button>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage"
                    class="flex justify-center items-center size-8 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white"
                    aria-label="Next »">
                    <x-ui.icon name="chevron-right" class="shrink-0 size-5" />
                </button>
            @else
                <span class="flex justify-center items-center size-8 rounded-[6px] text-zinc-300 dark:text-zinc-500">
                    <x-ui.icon name="chevron-right" class="shrink-0 size-5" />
                </span>
            @endif
        </div>
    </div>
@endif
