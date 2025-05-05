<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <flux:field>
        <flux:label for="name">{{ __('Role name') }}</flux:label>
        <flux:input id="name" type="text" wire:model="name" placeholder="{{ __('Enter role name') }}" />
        <flux:error name="name" />
    </flux:field>
</div>

<div class="flex flex-col gap-y-6 py-8">
    <flux:field>
        <flux:label>{{ __('Select the permissions for this role') }}:</flux:label>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($modules as $module => $permissions)
                <div class="rounded-xl border border-muted p-4 shadow-sm dark:border-gray-700 bg-white dark:bg-gray-900">
                    <h4 class="font-semibold text-base text-foreground dark:text-gray-200">{{ $module }}</h4>
                    <div class="mt-3 space-y-2">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center space-x-2 text-sm text-foreground dark:text-gray-300">
                                <input type="checkbox"
                                       wire:model="selectedPermissions"
                                       value="{{ $permission->id }}"
                                       class="rounded text-primary focus:ring focus:ring-primary/30 dark:bg-gray-800 dark:border-gray-600">
                                <span>{{ ucfirst($permission->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-sm text-muted dark:text-gray-400">{{ __('No permissions available') }}</p>
            @endforelse
        </div>
        @error('permissions')
            <p class="text-sm text-destructive dark:text-red-400">{{ $message }}</p>
        @enderror
    </flux:field>
</div>