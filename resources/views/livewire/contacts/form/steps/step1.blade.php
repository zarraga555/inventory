<div class="space-y-4">
    <h3 class="text-xl font-semibold">{{ __('Basic Information') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Document Type --}}
        <flux:field>
            <flux:label>{{ __('Document Type') }}</flux:label>
            <flux:select wire:model="contact_tax_id_type">
                <flux:select.option value="">{{ __('Select an option') }}</flux:select.option>
                <flux:select.option value="CI">CI</flux:select.option>
                <flux:select.option value="NIT">NIT</flux:select.option>
                <flux:select.option value="CEX">CEX</flux:select.option>
                <flux:select.option value="PAS">PASAPORTE</flux:select.option>
            </flux:select>
            <flux:error name="contact_tax_id_type" />
        </flux:field>

        {{-- Document Number --}}
        <flux:field>
            <flux:label>{{ __('Document Number') }}</flux:label>
            <flux:input type="text" wire:model="contact_tax_id_number" placeholder="123456789"/>
            <flux:error name="contact_tax_id_number" />
        </flux:field>

        {{-- Legal Name --}}
        <flux:field>
            <flux:label>{{ __('Legal Name (Tax Name)') }}</flux:label>
            <flux:input type="text" wire:model="contact_tax_name" placeholder="Empresa S.R.L."/>
            <flux:error name="contact_tax_name" />
        </flux:field>

        {{-- Trade Name --}}
        <flux:field>
            <flux:label>{{ __('Trade Name or Company') }}</flux:label>
            <flux:input type="text" wire:model="contact_company_name" placeholder="Empresa S.R.L."/>
            <small class="text-gray-500 text-sm">{{ __('Fill only if it is a company or supplier') }}</small>
            <flux:error name="contact_company_name" />
        </flux:field>

        {{-- First Name --}}
        <flux:field>
            <flux:label>{{ __('First Name') }}</flux:label>
            <flux:input type="text" wire:model="contact_first_name" placeholder="Juan"/>
            <flux:error name="contact_first_name" />
        </flux:field>

        {{-- Last Name --}}
        <flux:field>
            <flux:label>{{ __('Last Name') }}</flux:label>
            <flux:input type="text" wire:model="contact_last_name" placeholder="Perez"/>
            <flux:error name="contact_last_name" />
        </flux:field>
    </div>
</div>