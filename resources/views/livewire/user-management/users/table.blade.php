<x-flux.table.search model="search" placeholder="Search for users..." />
<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.sortable-column field="name" label="Name" :sortField="$sortField" :sortDirection="$sortDirection" />
        <x-flux.table.sortable-column field="email" label="Email" :sortField="$sortField" :sortDirection="$sortDirection" />
        <x-flux.table.column>{{ __('Role') }}</x-flux.table.column>
        @if (auth()->user()?->can('users.logs.view') || auth()->user()?->can('users.update'))
            <x-flux.table.column>{{ __('Actions') }}</x-flux.table.column>
        @endif
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($users as $user)
            <x-flux.table.row>
                <x-flux.table.cell>{{ $user->name }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $user->email }}</x-flux.table.cell>
                <x-flux.table.cell>
                    {{ $user->roles->pluck('name')->first() ?? __('No role') }}
                </x-flux.table.cell>

                @if (auth()->user()?->can('users.logs.view') || auth()->user()?->can('users.update'))
                    <x-flux.table.cell>
                        @can('users.update')
                            <a href="{{ route('user-management.users.edit', $user->id) }} "
                                class="text-blue-500 hover:underline" wire:navigate>{{ __('Edit') }}</a>
                        @endcan

                        @can('users.logs.view')
                            @can('users.update')
                                |
                            @endcan
                            <a href="{{ route('user-management.users.logs.view', $user->id) }}"
                                class="text-primary-500 hover:underline" wire:navigate>{{ __('See activity') }}</a>
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

<x-flux.table.pagination :paginator="$users" />
