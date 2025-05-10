<flux:modal name="confirmingCustomerGroupsDeletion" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Delete Customer Groups?') }}</flux:heading>

            <flux:text class="mt-2">
                <p>{{ __('You are about to delete this Customer Groups.') }}</p>
                <p>{{ __('This action cannot be undone.') }}</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" wire:click="delete">{{ __('Delete Customer Groups') }}</flux:button>
        </div>
    </div>
</flux:modal>