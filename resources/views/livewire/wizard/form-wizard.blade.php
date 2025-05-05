<div class="max-w-xl mx-auto space-y-4">
    <flux:card>
        <flux:card-header>
            <h2 class="text-lg font-semibold">Paso {{ $step }} de 3</h2>
        </flux:card-header>

        <flux:card-content>
            @if ($step === 1)
                <flux:input label="Nombre" wire:model.defer="data.name" />
                @error('data.name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            @endif

            @if ($step === 2)
                <flux:input label="Email" type="email" wire:model.defer="data.email" />
                @error('data.email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            @endif

            @if ($step === 3)
                <flux:input label="Contraseña" type="password" wire:model.defer="data.password" />
                @error('data.password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            @endif
        </flux:card-content>

        <flux:card-footer class="flex justify-between">
            @if ($step > 1)
                <flux:button wire:click="previousStep" variant="outline">Atrás</flux:button>
            @endif

            @if ($step < 3)
                <flux:button wire:click="nextStep">Siguiente</flux:button>
            @else
                <flux:button wire:click="submit">Finalizar</flux:button>
            @endif
        </flux:card-footer>
    </flux:card>

    @if (session()->has('message'))
        <flux:alert variant="success">{{ session('message') }}</flux:alert>
    @endif
</div>
