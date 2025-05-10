<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <flux:field>
        <flux:label>{{ __('Name') }}</flux:label>
        <flux:input type="text" wire:model="name" placeholder="{{ __('Enter a name') }}" />
        <flux:error name="name" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Amount in percentage (%)') }}</flux:label>
        <flux:input type="number" wire:model="amount" placeholder="{{ __('-10 0r 10') }}" />
        <flux:error name="amount" />
    </flux:field>
</div>
