<div>
    <div class="mb-4">
        <h2 class="text-xl font-bold">{{ __('Step') }} {{ $currentStep }} {{ __('of') }} 4</h2>
    </div>

    @if ($currentStep === 1)
        @include('livewire.contacts.form.steps.step1')
    @elseif ($currentStep === 2)
        @include('livewire.contacts.form.steps.step2')
    @elseif ($currentStep === 3)
        @include('livewire.contacts.form.steps.step3')
    @elseif ($currentStep === 4)
        @include('livewire.contacts.form.steps.step4')
    @endif

    <div class="flex justify-start mt-6 space-x-2">
        @if ($currentStep > 1)
            <flux:button wire:click="previousStep" variant="outline">{{ __('Back') }}</flux:button>
        @endif

        @if ($currentStep < 4)
            <flux:button wire:click="nextStep">{{ __('Next') }}</flux:button>
        @endif
    </div>
</div>
<flux:separator class="mt-4" variant="subtitle" />
