@section('title')
    {{ __('Users') }}
@endsection
<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Users') }}</flux::heading>
                    <flux:subheading size="lg">{{ __('Manage your users') }}</flux::subheading>
            </div>
            @can('users.create')
                <flux:button href="{{ route('user-management.users.create') }}" variant="primary" wire:navigate>
                    {{ __('Create new user') }}
                </flux:button>
            @endcan
        </div>
    </div>
    <flux:separator variant="subtitle" />
    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.user-management.users.table')
    </div>
</div>
