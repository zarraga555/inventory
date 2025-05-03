<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.column>{{ __('Name') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Email') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Role') }}</x-flux.table.column>
        @if (auth()->user()?->can('users.logs.view') || auth()->user()?->can('users.update'))
            <x-flux.table.column>{{ __('Actions') }}</x-flux.table.column>
        @endif

    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($users as $user)
            <x-flux.table.row>
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    {{ isset($user->roles->pluck('name')[0]) ? $user->roles->pluck('name')[0] : __('No role') }}
                </td>
                @if (auth()->user()?->can('users.logs.view') || auth()->user()?->can('users.update'))
                    <td class="px-6 py-4">
                        @can('users.update')
                            <a href="{{ route('user-management.users.edit', $user->id) }}"
                                class="text-blue-500 hover:underline">{{ __('Edit') }}</a>
                        @endcan
                        @can('users.logs.view')
                            | <a href="{{ route('user-management.users.edit', $user->id) }}"
                                class="text-primary-500 hover:underline">{{ __('See activity') }}</a>
                        @endcan
                    </td>
                @endif

            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <td class="px-6 py-4" colspan="4">
                    {{ __('No records were found. Please create a record to get started.') }}</td>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>

<x-flux.table.pagination :paginator="$users" />
