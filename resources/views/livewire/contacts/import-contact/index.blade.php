@section('title')
    {{ __('Import Contacts') }}
@endsection

<div>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center">
            <div>
                <flux:heading size="xl" level="1">
                    {{ __('Import Contacts') }}
                </flux:heading>
                <flux:subheading size="lg">
                    {{ __('Import your contacts as your customers and suppliers, download the template to fill in your data.') }}
                </flux:subheading>
            </div>
        </div>
    </div>

    <flux:separator variant="subtitle" />

    <div class="mt-6 ">

        {{-- Sección: Importar archivo --}}
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>{{ __('File to import:') }}</flux:label>
                    <flux:input type="file" wire:model="file" placeholder="{{ __('Enter a name') }}" accept=".xlsx, .xls, .csv"/>
                    <flux:error name="file" />
                </flux:field>
            </div>
            <div class="fi-ac gap-3 flex flex-wrap items-center justify-start mt-8">
                <flux:button variant="primary" wire:click="importContacts">{{ __('Import Contacts') }}</flux:button>
                <flux:button wire:click="downloadTemplate">{{ __('Download template file') }}</flux:button>
            </div>
            
            {{-- <div class="mt-6">
                <a href="{{ url('/files/import_contacts_csv_template.xls') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                    download>
                    <i class="fa fa-download mr-2"></i> Descargar archivo de plantilla
                </a>
            </div> --}}
        </div>

        {{-- Sección: Instrucciones --}}
        <div class="mt-6">
            <flux:heading size="lg" level="2">{{ __('Instructions') }}</flux:heading>

            <p class="text-sm text-gray-600 dark:text-gray-400 mt-4 mb-4">
                <strong>{{ __('Follow the instructions carefully before importing the file.') }}</strong><br>
                {{ __('The columns in the CSV, XLS, or XLSX file must be in the following order:') }}
            </p>
            @include('livewire.contacts.import-contact.table')
        </div>
    </div>
</div>