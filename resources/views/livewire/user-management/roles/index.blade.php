@section('title')
    {{ __('Roles') }}
@endsection
<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Roles') }}</flux::heading>
                    <flux:subheading size="lg">{{ __('Manage your roles') }}</flux::subheading>
            </div>
            <flux:button href="{{ route('user-management.roles.create') }}" variant="primary" wire:navigate>
                {{ __('Create new role') }}
            </flux:button>
        </div>
    </div>
    <flux:separator variant="subtitle" />
    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.user-management.roles.table')
    </div>
</div>
