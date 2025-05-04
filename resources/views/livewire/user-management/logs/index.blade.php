@section('title')
    {{ __('Activity Logs') }}
@endsection

<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">{{ __('Activity Logs of') }}: {{ $user->name }}
                </flux:heading>
                <flux:subheading size="lg">{{ __('Email') }}: {{ $user->email }}</flux:subheading>
                <flux:subheading class="mb-2" size="lg">
                    {{ __('View the actions performed by the user in the system.') }}</flux:subheading>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('user-management.users.index') }}" wire:navigate>
                        {{ __('Users') }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ __('Activity Logs') }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
            <flux:button href="{{ route('user-management.users.index') }}" wire:navigate
                icon="arrow-left">
                {{ __('Back to Users') }}
            </flux:button>
        </div>
    </div>
    <flux:separator variant="subtitle" />
    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.user-management.logs.table')
        @include('livewire.user-management.logs.informationChanges')
    </div>
</div>
