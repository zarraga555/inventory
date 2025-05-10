<div class="space-y-4">
    <h3 class="text-xl font-semibold">{{ __('Address') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Address Line 1 --}}
        <flux:field>
            <flux:label>{{ __('Address Line 1') }}</flux:label>
            <flux:input type="email" wire:model="contact_address_line_1" placeholder="Calle, número, zona" />
            <flux:error name="contact_address_line_1" />
        </flux:field>

        {{-- Address Line 2 --}}
        <flux:field>
            <flux:label>{{ __('Address Line 2') }}</flux:label>
            <flux:input type="email" wire:model="contact_address_line_2" placeholder="Calle, número, zona" />
            <flux:error name="contact_address_line_2" />
        </flux:field>

        {{-- City --}}
        <flux:field>
            <flux:label>{{ __('City') }}</flux:label>
            <flux:input type="text" wire:model="contact_city" placeholder="Cochabamba" />
            <flux:error name="contact_city" />
        </flux:field>

        {{-- State / Department --}}
        <flux:field>
            <flux:label>{{ __('State / Department') }}</flux:label>
            <flux:input type="text" wire:model="contact_state" placeholder="Cercado" />
            <flux:error name="contact_state" />
        </flux:field>

        {{-- Country --}}
        <flux:field>
            <flux:label>{{ __('Country') }}</flux:label>
            <flux:input type="text" wire:model="contact_country" placeholder="Bolivia" />
            <flux:error name="contact_country" />
        </flux:field>

        {{-- Zip Code --}}
        <flux:field>
            <flux:label>{{ __('Zip Code') }}</flux:label>
            <flux:input type="text" wire:model="contact_zip_code" placeholder="0000" />
            <flux:error name="contact_zip_code" />
        </flux:field>
    </div>
</div>
