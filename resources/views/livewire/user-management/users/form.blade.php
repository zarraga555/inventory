<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <flux:field>
        <flux:label>{{ __('Full Name') }}</flux:label>
        <flux:input type="text" wire:model="name" placeholder="{{ __('Enter your full name') }}" />
        <flux:error name="name" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Email') }}</flux:label>
        <flux:input type="email" wire:model="email" placeholder="{{ __('Enter your email address') }}" />
        <flux:error name="email" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Password') }}</flux:label>
        <flux:input type="password" wire:model="password" placeholder="{{ __('Enter your password') }}" />
        <flux:error name="password" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('Confirm password') }}</flux:label>
        <flux:input type="password" wire:model="password_confirmation" placeholder="{{ __('Repeat your password') }}" />
        <flux:error name="password_confirmation" />
    </flux:field>

    <flux:field>
        <flux:label>{{ __('User type') }}</flux:label>
        <flux:select wire:model="user_type">
            <flux:select.option value="" selected>{{ __('Select an option') }}</flux:select.option>
            <!-- Agrega tus opciones aquí -->
        </flux:select>
        <flux:error name="user_type" />
    </flux:field>
</div>