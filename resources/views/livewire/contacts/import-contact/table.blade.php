<x-flux.table>
    <x-flux.table.columns>
        <x-flux.table.column>{{ __('#') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Column name') }}</x-flux.table.column>
        <x-flux.table.column>{{ __('Instructions') }}</x-flux.table.column>
    </x-flux.table.columns>

    <x-flux.table.rows>
        @forelse ($columnas as $index => [$columna, $tipo, $info, $instructions])
            <x-flux.table.row>
                <x-flux.table.cell>{{ $index + 1 }}</x-flux.table.cell>
                <x-flux.table.cell>{{ $columna }} ({{__($tipo)}})
                    @if ($tipo)
                        <small class="block text-gray-500 dark:text-gray-400">{{ __($info) }}</small>
                    @endif
                </x-flux.table.cell>
                <x-flux.table.cell>{!! $instructions ? '<strong>' . __($instructions) . '</strong>' : '&nbsp;' !!}</x-flux.table.cell>
            </x-flux.table.row>
        @empty
            <x-flux.table.row>
                <x-flux.table.cell
                    colspan="4">{{ __('No client group was found. Create some to get started.') }}</x-flux.table.cell>
            </x-flux.table.row>
        @endforelse
    </x-flux.table.rows>
</x-flux.table>
