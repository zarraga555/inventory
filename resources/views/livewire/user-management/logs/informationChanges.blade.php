<flux:modal name="show-changes" variant="flyout">
    <div class="w-full max-w-sm sm:w-[95vw] mx-auto p-4 overflow-y-auto overflow-x-hidden break-words max-h-[90vh]">

        <flux:heading size="lg" class="text-primary-600 dark:text-primary-400">
            {{ __('Log Details') }}
        </flux:heading>

        @if (!empty($selectedChanges))
            <div class="space-y-4 text-sm text-gray-800 dark:text-gray-200">

                {{-- Acción --}}
                @if (!empty($selectedChanges['action']))
                    <div class="bg-gray-100 dark:bg-gray-700 border-l-4 border-primary-500 px-4 py-2 rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ __('Action performed') }}:</span>
                        <span class="ml-2 capitalize font-semibold text-primary-700 dark:text-primary-300">
                            {{ __(ucfirst($selectedChanges['action'])) }}
                        </span>
                    </div>
                @endif

                {{-- Entidad --}}
                @if (!empty($selectedChanges['entity']))
                    <div class="bg-gray-50 dark:bg-gray-800 border-l-4 border-indigo-500 px-4 py-2 rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ __('Entity') }}:</span>
                        <span class="ml-2 capitalize text-indigo-700 dark:text-indigo-300">
                            {{ __(ucfirst($selectedChanges['entity'])) }}
                        </span>
                    </div>
                @endif

                {{-- Antes --}}
                @if (!empty($selectedChanges['before']))
                    <div class="pl-4 border-l-4 border-yellow-500">
                        <h3 class="font-semibold text-yellow-600 dark:text-yellow-300 mb-2">{{ __('Before Changes') }}:</h3>
                        <div class="space-y-1">
                            @foreach ($selectedChanges['before'] as $key => $value)
                                <div class="break-words">
                                    <span class="text-gray-500 dark:text-gray-400">{{ ucfirst($key) }}:</span>
                                    <span class="ml-2 text-red-600 dark:text-red-300">
                                        {{ is_array($value) ? implode(', ', $value) : $value }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Después --}}
                @if (!empty($selectedChanges['after']))
                    <div class="pl-4 border-l-4 border-green-500">
                        <h3 class="font-semibold text-green-600 dark:text-green-300 mb-2">{{ __('After Changes') }}:</h3>
                        <div class="space-y-1">
                            @foreach ($selectedChanges['after'] as $key => $value)
                                <div class="break-words">
                                    <span class="text-gray-500 dark:text-gray-400">{{ ucfirst($key) }}:</span>
                                    <span class="ml-2 text-green-700 dark:text-green-300">
                                        {{ is_array($value) ? implode(', ', $value) : $value }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Usuario --}}
                @if (!empty($selectedChanges['performed_by']))
                    <div class="pl-4 border-l-4 border-gray-400">
                        <h3 class="font-semibold text-gray-600 dark:text-gray-300 mb-2">{{ __('Performed By') }}:</h3>
                        <div class="space-y-1">
                            @foreach ($selectedChanges['performed_by'] as $key => $value)
                                <div class="break-words">
                                    <span class="text-gray-500 dark:text-gray-400">{{ ucfirst($key) }}:</span>
                                    <span class="ml-2">
                                        {{ is_array($value) ? implode(', ', $value) : $value }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <flux:text class="text-center text-gray-500 dark:text-gray-400">
                {{ __('No changes available.') }}
            </flux:text>
        @endif
    </div>
</flux:modal>
