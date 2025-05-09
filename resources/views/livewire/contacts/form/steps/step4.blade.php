<div class="space-y-4">
    <h3 class="text-xl font-semibold">{{ __('Financial Information') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Opening Balance --}}
        <flux:field>
            <flux:label>{{ __('Opening Balance') }}</flux:label>
            <flux:input type="number" step="0.01" wire:model="contact_opening_balance" placeholder="1000.00" />
            <flux:error name="contact_opening_balance" />
        </flux:field>

        {{-- Credit Limit --}}
        <flux:field>
            <flux:label>{{ __('Credit Limit') }}</flux:label>
            <flux:input type="number" step="0.01" wire:model="contact_credit_limit" placeholder="1000.00" />
            <flux:error name="contact_credit_limit" />
        </flux:field>

        {{-- Payment Term Value --}}
        <flux:field>
            <flux:label>{{ __('Payment Term (Value)') }}</flux:label>
            <flux:input type="number" wire:model="contact.payment_term_value" placeholder="30" />
            <flux:error name="contact.payment_term_value" />
        </flux:field>

        {{-- Payment Term Type --}}
        <flux:field>
            <flux:label>{{ __('Payment Term Type') }}</flux:label>
            <flux:select wire:model="contact.customer_group_id">
                <flux:select.option value="">{{ __('Select an option') }}</flux:select.option>
                <flux:select.option value="days">{{ __('Days') }}</flux:select.option>
                <flux:select.option value="months">{{ __('Months') }}</flux:select.option>
            </flux:select>
            <flux:error name="contact.customer_group_id" />
        </flux:field>

        {{-- Customer Group --}}
        <flux:field>
            <flux:label>{{ __('Customer Group') }}</flux:label>
            <flux:select wire:model="contact.customer_group_id">
                <flux:select.option value="">{{ __('Select an option') }}</flux:select.option>
                @foreach ($customerGroups as $group)
                    <flux:select.option value="{{ $group->id }}">{{ $group->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:error name="contact.customer_group_id" />
        </flux:field>
    </div>
</div>