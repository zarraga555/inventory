@section('title')
    {{ __('Create new user') }}
@endsection
<div>
    <div class="mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading class="mb-2" size="xl" level="1">{{ __('Create new user') }}</flux::heading>
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item href="{{ route('user-management.users.index') }}" wire:navigate>
                            {{ __('Users') }}
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item>{{ __('Create') }}</flux:breadcrumbs.item>
                    </flux:breadcrumbs>
            </div>
        </div>
    </div>
    <flux:separator variant="subtitle" />

    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.user-management.users.form')
    </div>

    <div class="fi-ac gap-3 flex flex-wrap items-center justify-start mt-8">
        <flux:button variant="primary" wire:click="save">{{ __('Save') }}</flux:button>
        <flux:button wire:click="saveAndCreateAnother">{{ __('Save and create another') }}</flux:button>
        <flux:button href="{{ route('user-management.users.index') }}" wire:navigate>{{ __('Cancel') }}</flux:button>
    </div>
</div>
