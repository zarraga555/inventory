<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}

        {{-- Footer global aquí --}}
        <div class="mt-10 border-t border-zinc-200 dark:border-zinc-700 pt-6 text-sm text-zinc-600 dark:text-zinc-400">
            <div class="flex flex-col items-center justify-between gap-2 sm:flex-row">
                <p>&copy; {{ now()->year }} {{ config('app.company.name') }}. {{ __('All rights reserved.') }}</p>
                {{-- <div class="flex gap-4">
                    <a href="{{ route('settings.profile') }}" class="hover:underline">{{ __('Settings') }}</a>
                    <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="hover:underline">GitHub</a>
                </div> --}}
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>