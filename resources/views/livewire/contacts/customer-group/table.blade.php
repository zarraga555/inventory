<x-flux.table.search model="search" placeholder="Search customer group..." />

<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.sortable-column field="name" label="Name" :sortField="$sortField" :sortDirection="$sortDirection" />
        <x-flux.table.column>{{ __('Amount') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Price calculation type') }}</x-flux.table.column>
        @if (auth()->user()?->can('customer-group.update'))
            <x-flux.table.column>{{ __('Actions') }}</x-flux.table.column>
        @endif
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($customer_groups as $customer_group)
            <x-flux.table.row>
                <x-flux.table.cell>{{ $customer_group->name }}</x-flux.table.cell>
                <x-flux.table.cell>{{ number_format($customer_group->amount, 2) }}{{ $customer_group->price_calculation_type === 'percentage' ? '%' : '' }}</x-flux.table.cell>
                <x-flux.table.cell>{{ __($customer_group->price_calculation_type) }}</x-flux.table.cell>
                <x-flux.table.cell>
                  @can('customer-group.update')
                  <a href="{{ route('contacts.customer-group.edit', $customer_group->id) }} "
                      class="text-blue-500 hover:underline" wire:navigate>{{ __('Edit') }}</a>
              @endcan
                </x-flux.table.cell>
            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <x-flux.table.cell
                    colspan="4">{{ __('No client group was found. Create some to get started.') }}</x-flux.table.cell>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>

<x-flux.table.pagination :paginator="$customer_groups" />
