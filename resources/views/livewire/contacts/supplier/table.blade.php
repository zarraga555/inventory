<x-flux.table.search model="search" placeholder="Buscar clientes..." />

<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.sortable-column field="full_name" label="Full Name" :sortField="$sortField" :sortDirection="$sortDirection" />
        <x-flux.table.column>{{ __('Company Name') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Phone Mobile') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Email') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Balance') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Credit limit') }}</x-flux.table.column>
        @if (auth()->user()?->can('supplier.view') || auth()->user()?->can('supplier.update'))
            <x-flux.table.column>{{ __('Actions') }}</x-flux.table.column>
        @endif
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($suppliers as $supplier)
            <x-flux.table.row>
                <x-flux.table.cell>{{ $supplier->full_name ?? $supplier->first_name . ' ' . $supplier->last_name }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $supplier->company_name ?? '-' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $supplier->phone_mobile ?? '-' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $supplier->email ?? '-' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ number_format($supplier->opening_balance ?? 0, 2) }}</x-flux.table.cell>
                <x-flux.table.cell>{{ number_format($supplier->credit_limit ?? 0, 2) }}</x-flux.table.cell>
                @if (auth()->user()?->can('supplier.view') || auth()->user()?->can('supplier.update'))
                    <x-flux.table.cell>
                        @can('supplier.update')
                            <a href="{{ route('contacts.supplier.edit', $supplier->id) }}"
                                class="text-blue-500 hover:underline" wire:navigate>{{ __('Edit') }}</a>
                        @endcan

                        @can('supplier.view')
                            @can('supplier.update')
                                |
                            @endcan
                            <a href="#" {{-- {{ route('contacts.suppliers.show', $supplier->id) }} --}} class="text-primary-500 hover:underline"
                                wire:navigate>{{ __('View') }}</a>
                        @endcan
                    </x-flux.table.cell>
                @endif
            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <x-flux.table.cell colspan="7">{{ __('No suppliers found') }}</x-flux.table.cell>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>

<x-flux.table.pagination :paginator="$suppliers" />
