<div class="space-y-4">
    <h3 class="text-xl font-semibold">{{ __('Basic Information') }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Document Type --}}
        <flux:field>
            <flux:label>{{ __('Document Type') }}</flux:label>
            <flux:select wire:model.defer="tax_id_type">
                <flux:select.option value="">{{ __('Select an option') }}</flux:select.option>
                <flux:select.option value="CI">CI</flux:select.option>
                <flux:select.option value="NIT">NIT</flux:select.option>
                <flux:select.option value="CEX">CEX</flux:select.option>
                <flux:select.option value="PAS">PASAPORTE</flux:select.option>
            </flux:select>
            <flux:error name="tax_id_type" />
        </flux:field>

        {{-- Document Number --}}
        <flux:field>
            <flux:label>{{ __('Document Number') }}</flux:label>
            <flux:input type="text" wire:model.defer="tax_id_number" placeholder="123456789" />
            <flux:error name="tax_id_number" />
        </flux:field>

        {{-- Legal Name --}}
        <flux:field>
            <flux:label>{{ __('Legal Name (Tax Name)') }}</flux:label>
            <flux:input type="text" wire:model.defer="tax_name" placeholder="Empresa S.R.L." />
            <flux:error name="tax_name" />
        </flux:field>

        {{-- Trade Name --}}
        <flux:field>
            <flux:label>{{ __('Trade Name or Company') }}</flux:label>
            <flux:input type="text" wire:model.defer="company_name" placeholder="Empresa S.R.L." />
            <small class="text-gray-500 text-sm">{{ __('Fill only if it is a company or supplier') }}</small>
            <flux:error name="company_name" />
        </flux:field>

        {{-- First Name --}}
        <flux:field>
            <flux:label>{{ __('First Name') }}</flux:label>
            <flux:input type="text" wire:model.defer="first_name" placeholder="Juan" />
            <flux:error name="first_name" />
        </flux:field>

        {{-- Last Name --}}
        <flux:field>
            <flux:label>{{ __('Last Name') }}</flux:label>
            <flux:input type="text" wire:model.defer="last_name" placeholder="Perez" />
            <flux:error name="last_name" />
        </flux:field>
    </div>
</div>

<div class="flex justify-center text-center pt-4">
    @if ($show)
        <flux:button icon="eye-slash" wire:click="hideEntries" variant="outline">
            {{ __('Hide more information') }}
        </flux:button>
    @else
        <flux:button icon="eye" wire:click="showEntries" variant="outline">
            {{ __('Show more information') }}
        </flux:button>
    @endif
</div>

@if ($show)
    <flux:separator class="mt-4 mb-4" variant="subtitle" />
    <div class="space-y-4">
        <h3 class="text-xl font-semibold">{{ __('Contact') }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Email --}}
            <flux:field>
                <flux:label>{{ __('Email') }}</flux:label>
                <flux:input type="email" wire:model.defer="email" placeholder="example@example.com" />
                <flux:error name="email" />
            </flux:field>

            {{-- Phone Mobile --}}
            <flux:field>
                <flux:label>{{ __('Phone Mobile') }}</flux:label>
                <flux:input type="text" wire:model.defer="phone_mobile" placeholder="1234567890" />
                <flux:error name="phone_mobile" />
            </flux:field>

            {{-- Phone Landline --}}
            <flux:field>
                <flux:label>{{ __('Phone Landline') }}</flux:label>
                <flux:input type="text" wire:model.defer="phone_landline" placeholder="1234567890" />
                <flux:error name="phone_landline" />
            </flux:field>

            {{-- Phone Alternate --}}
            <flux:field>
                <flux:label>{{ __('Phone Alternate') }}</flux:label>
                <flux:input type="text" wire:model.defer="phone_alternate" placeholder="1234567890" />
                <flux:error name="phone_alternate" />
            </flux:field>
        </div>
    </div>
    <flux:separator class="mt-4 mb-4" variant="subtitle" />
    <div class="space-y-4">
        <h3 class="text-xl font-semibold">{{ __('Address') }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Address Line 1 --}}
            <flux:field>
                <flux:label>{{ __('Address Line 1') }}</flux:label>
                <flux:input type="text" wire:model.defer="address_line_1" placeholder="Calle, número, zona" />
                <flux:error name="address_line_1" />
            </flux:field>

            {{-- Address Line 2 --}}
            <flux:field>
                <flux:label>{{ __('Address Line 2') }}</flux:label>
                <flux:input type="text" wire:model.defer="address_line_2" placeholder="Calle, número, zona" />
                <flux:error name="address_line_2" />
            </flux:field>

            {{-- City --}}
            <flux:field>
                <flux:label>{{ __('City') }}</flux:label>
                <flux:input type="text" wire:model.defer="city" placeholder="Cochabamba" />
                <flux:error name="city" />
            </flux:field>

            {{-- State / Department --}}
            <flux:field>
                <flux:label>{{ __('State / Department') }}</flux:label>
                <flux:input type="text" wire:model.defer="state" placeholder="Cercado" />
                <flux:error name="state" />
            </flux:field>

            {{-- Country --}}
            <flux:field>
                <flux:label>{{ __('Country') }}</flux:label>
                <flux:input type="text" wire:model.defer="country" placeholder="Bolivia" />
                <flux:error name="country" />
            </flux:field>

            {{-- Zip Code --}}
            <flux:field>
                <flux:label>{{ __('Zip Code') }}</flux:label>
                <flux:input type="text" wire:model.defer="zip_code" placeholder="0000" />
                <flux:error name="zip_code" />
            </flux:field>
        </div>
    </div>
    <flux:separator class="mt-4 mb-4" variant="subtitle" />
    <div class="space-y-4">
        <h3 class="text-xl font-semibold">{{ __('Financial Information') }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Opening Balance --}}
            <flux:field>
                <flux:label>{{ __('Opening Balance') }}</flux:label>
                <flux:input type="number" step="0.01" wire:model.defer="opening_balance" placeholder="1000.00" />
                <flux:error name="opening_balance" />
            </flux:field>

            {{-- Credit Limit --}}
            <flux:field>
                <flux:label>{{ __('Credit Limit') }}</flux:label>
                <flux:input type="number" step="0.01" wire:model.defer="credit_limit" placeholder="1000.00" />
                <flux:error name="credit_limit" />
            </flux:field>

            {{-- Payment Term Value --}}
            <flux:field>
                <flux:label>{{ __('Payment Term (Value)') }}</flux:label>
                <flux:input type="number" wire:model.defer="payment_term_value" placeholder="30" />
                <flux:error name="payment_term_value" />
            </flux:field>

            {{-- Payment Term Type --}}
            <flux:field>
                <flux:label>{{ __('Payment Term Type') }}</flux:label>
                <flux:select wire:model.defer="payment_term_type">
                    <flux:select.option value="">{{ __('Select an option') }}</flux:select.option>
                    <flux:select.option value="days">{{ __('Days') }}</flux:select.option>
                    <flux:select.option value="months">{{ __('Months') }}</flux:select.option>
                </flux:select>
                <flux:error name="payment_term_type" />
            </flux:field>

            {{-- Customer Group --}}
            <flux:field>
                <flux:label>{{ __('Customer Group') }}</flux:label>
                <flux:select wire:model.defer="customer_group_id">
                    <flux:select.option value="">{{ __('Select an option') }}</flux:select.option>
                    @foreach ($customerGroups as $group)
                        <flux:select.option value="{{ $group->id }}">{{ $group->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="customer_group_id" />
            </flux:field>
        </div>
    </div>
@endif
