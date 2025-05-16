@section('title')
    {{ __('Edit supplier') }}
@endsection
<div>
    <div class="mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading class="mb-2" size="xl" level="1">{{ __('Edit supplier') }}</flux::heading>
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item href="{{ route('contacts.supplier.index') }}" wire:navigate>
                            {{ __('Supplier') }}
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item>{{ __('Edit') }}</flux:breadcrumbs.item>
                    </flux:breadcrumbs>
            </div>
            @can('supplier.delete')
                <flux:modal.trigger name="confirmingCustomerDeletion">
                    <flux:button variant="danger">{{ __('Delete') }}</flux:button>
                </flux:modal.trigger>
            @endcan
        </div>
    </div>
    <flux:separator variant="subtitle" />

    <div class="mt-8 self-stretch max-md:pt-6">
        @include('livewire.contacts.form.form')
        @include('livewire.contacts.modal.modalDelete')
    </div>

    <div class="fi-ac gap-3 flex flex-wrap items-center justify-start mt-8">
        <flux:button variant="primary" wire:click="update">{{ __('Save changes') }}</flux:button>
        <flux:button href="{{ route('contacts.supplier.index') }}" wire:navigate>{{ __('Cancel') }}</flux:button>
    </div>
</div>
