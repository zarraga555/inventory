@section('title')
    {{ __('Customer Groups') }}
@endsection
<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Customer Groups') }}</flux::heading>
                    <flux:subheading size="lg">{{ __('Manage your customer groups') }}</flux::subheading>
            </div>
            @can('customer-group.create')
                <flux:button href="{{ route('contacts.customer-group.create') }}" variant="primary" wire:navigate>
                    {{ __('Create new customer group') }}
                </flux:button>
            @endcan
        </div>
    </div>
    <flux:separator variant="subtitle" />
    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.contacts.customer-group.table')
    </div>
</div>