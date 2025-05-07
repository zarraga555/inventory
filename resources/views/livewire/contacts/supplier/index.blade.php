@section('title')
    {{ __('Suppliers') }}
@endsection
<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Suppliers') }}</flux::heading>
                    <flux:subheading size="lg">{{ __('Manage your suppliers') }}</flux::subheading>
            </div>
            @can('users.create')
                <flux:button href="{{ route('contacts.supplier.create') }}" variant="primary" wire:navigate>
                    {{ __('Create new supplier') }}
                </flux:button>
            @endcan
        </div>
    </div>
    <flux:separator variant="subtitle" />
    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.contacts.supplier.table')
    </div>
</div>