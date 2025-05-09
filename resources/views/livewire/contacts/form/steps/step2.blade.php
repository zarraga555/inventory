<div class="space-y-4">
    <h3 class="text-xl font-semibold">{{ __('Contact') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Email --}}
        <flux:field>
            <flux:label>{{ __('Email') }}</flux:label>
            <flux:input type="email" wire:model.defer="contact_email" placeholder="example@example.com"/>
            <flux:error name="contact_email" />
        </flux:field>

        {{-- Phone Mobile --}}
        <flux:field>
            <flux:label>{{ __('Phone Mobile') }}</flux:label>
            <flux:input type="text" wire:model.defer="contact_phone_mobile" placeholder="1234567890"/>
            <flux:error name="contact_phone_mobile" />
        </flux:field>

        {{-- Phone Landline --}}
        <flux:field>
            <flux:label>{{ __('Phone Landline') }}</flux:label>
            <flux:input type="text" wire:model.defer="contact_phone_landline" placeholder="1234567890"/>
            <flux:error name="contact_phone_landline" />
        </flux:field>

        {{-- Phone Alternate --}}
        <flux:field>
            <flux:label>{{ __('Phone Alternate') }}</flux:label>
            <flux:input type="text" wire:model.defer="contact_phone_alternate" placeholder="1234567890"/>
            <flux:error name="contact_phone_alternate" />
        </flux:field>
    </div>
</div>