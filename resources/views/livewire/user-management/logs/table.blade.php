<x-flux.table.search model="search" placeholder="Search for logs..." />

<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.column>{{ __('Name') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Action') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Model') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Description') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Changes') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('IP Address') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Date') }}</x-flux.table.column>
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($logs as $log)
            <x-flux.table.row>
                <x-flux.table.cell>
                    {{ $log->changes['performed_by']['name'] ?? '—' }}
                </x-flux.table.cell>

                <x-flux.table.cell class="capitalize">
                    {{ $log->action }}
                </x-flux.table.cell>

                <x-flux.table.cell>
                    {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                </x-flux.table.cell>

                <x-flux.table.cell>
                    {{ $log->description }}
                </x-flux.table.cell>

                <x-flux.table.cell>
                    <flux:modal.trigger name="show-changes" wire:click="showChanges({{ $log->id }})">
                        <button class="text-blue-500 hover:underline">{{ __('View') }}</button>
                    </flux:modal.trigger>
                </x-flux.table.cell>

                <x-flux.table.cell>{{ $log->ip }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $log->created_at->format('Y-m-d H:i:s') }}</x-flux.table.cell>
            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <x-flux.table.cell colspan="7">
                    {{ __('No activity logs were found.') }}
                </x-flux.table.cell>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>

<x-flux.table.pagination :paginator="$logs" />
