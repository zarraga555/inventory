<x-flux.table.search model="search" placeholder="Buscar clientes..." />

<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.sortable-column field="full_name" label="Full Name" :sortField="$sortField" :sortDirection="$sortDirection" />
        <x-flux.table.column>{{ __('Company Name') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Phone Mobile') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Email') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Balance') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Credit limit') }}</x-flux.table.column>
        @if (auth()->user()?->can('customer.view') || auth()->user()?->can('customer.update'))
            <x-flux.table.column>{{ __('Actions') }}</x-flux.table.column>
        @endif
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($customers as $customer)
            <x-flux.table.row>
                <x-flux.table.cell>{{ $customer->full_name ?? $customer->first_name . ' ' . $customer->last_name }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $customer->company_name ?? '-' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $customer->phone_mobile ?? '-' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $customer->email ?? '-' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ number_format($customer->opening_balance ?? 0, 2) }}</x-flux.table.cell>
                <x-flux.table.cell>{{ number_format($customer->credit_limit ?? 0, 2) }}</x-flux.table.cell>
                <x-flux.table.cell>
                    @if (auth()->user()?->can('customer.view') || auth()->user()?->can('customer.update'))
                        <x-flux.table.cell>
                            @can('customer.update')
                                <a href="{{ route('contacts.customer.edit', $customer->id) }}"
                                    class="text-blue-500 hover:underline" wire:navigate>{{ __('Edit') }}</a>
                            @endcan

                            @can('customer.view')
                                @can('customer.update')
                                    |
                                @endcan
                                <a href="#"
                                {{-- {{ route('contacts.customers.show', $customer->id) }} --}}
                                    class="text-primary-500 hover:underline" wire:navigate>{{ __('View') }}</a>
                            @endcan
                        </x-flux.table.cell>
                    @endif
                </x-flux.table.cell>
            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <x-flux.table.cell colspan="7">{{ __('No customers found') }}</x-flux.table.cell>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>

<x-flux.table.pagination :paginator="$customers" />
