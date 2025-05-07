@section('title')
    {{ __('Customers') }}
@endsection
<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Customers') }}</flux::heading>
                    <flux:subheading size="lg">{{ __('Manage your customers') }}</flux::subheading>
            </div>
            @can('users.create')
                <flux:button href="{{ route('contacts.customer.create') }}" variant="primary" wire:navigate>
                    {{ __('Create new customer') }}
                </flux:button>
            @endcan
        </div>
    </div>
    <flux:separator variant="subtitle" />
    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.contacts.customer.table')
    </div>
</div>