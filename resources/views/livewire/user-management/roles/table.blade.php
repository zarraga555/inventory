<x-flux.table.search model="search" placeholder="Search for roles..." />
<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.sortable-column field="name" label="Name" :sortField="$sortField" :sortDirection="$sortDirection" />
        <x-flux.table.column>{{ __('Permissions') }}</x-flux.table.column>
        @if (auth()->user()?->can('roles.update'))
            <x-flux.table.column>{{ __('Actions') }}</x-flux.table.column>
        @endif
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($roles as $role)
            <x-flux.table.row>
                <x-flux.table.cell>{{ $role->name }}</x-flux.table.cell>
                <x-flux.table.cell>
                    @foreach ($role->permissions as $permission)
                        <flux:badge size="sm">{{ __("{$permission->name}") }}</flux:badge>
                    @endforeach
                </x-flux.table.cell>

                @if (auth()->user()?->can('roles.update'))
                    <x-flux.table.cell>
                        @can('roles.update')
                            <a href="{{ route('user-management.roles.edit', $role->id) }}"
                                class="text-blue-500 hover:underline" wire:navigate>{{ __('Edit') }}</a>
                        @endcan
                    </x-flux.table.cell>
                @endif
            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <x-flux.table.cell colspan="4">
                    {{ __('No records were found. Please create a record to get started.') }}
                </x-flux.table.cell>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>

<x-flux.table.pagination :paginator="$roles" />
