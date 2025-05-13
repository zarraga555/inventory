<?php

namespace App\Livewire\Contacts\ImportContact;

use Livewire\Component;
use App\Traits\InteractsWithToasts;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactImport;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use InteractsWithToasts;
    use WithFileUploads;
    public $file;

    public function downloadTemplate()
    {
        $filePath = public_path('templates/import_contacts_template.xlsx');
        if (!file_exists($filePath)) {
            abort(404, 'El archivo no se encontró');
        }
        return response()->download($filePath);
    }

    public function importContacts()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $import = new ContactImport();

        try {
            Excel::import($import, $this->file);
        } catch (\Exception $e) {
            $this->showToastError('There was an error importing the file: ' . $e->getMessage());
            Log::error('Error importing contacts', ['exception' => $e]);
            return;
        }

        if ($import->failures()->isNotEmpty()) {
            foreach ($import->failures() as $failure) {
                $this->showToastError(
                    "Fila {$failure->row()}, columna '{$failure->attribute()}': " .
                        implode(', ', $failure->errors())
                );
            }
            $this->reset('file');
            return;
        } else {
            $this->reset('file');
            $this->showToastSuccess('Contacts successfully imported!', 'Import completed');
        }
    }

    public function render()
    {
        // $this->authorize('import', Contact::class);
        $fields = [
            // ['type', 'Contact Type', '(Required)', 'Options: 1 = Customer, 2 = Supplier, 3 = Both'],
            // ['DB Field (Excel Header)', 'Translated Header (English)', 'Requirement', 'Instructions'],   
            ['type', 'Contact Type', '(Required)', 'Options: 1 = Customer, 2 = Supplier'],
            ['company_name', 'Company Name', '(Conditionally Required)', 'Required if contact is supplier'],
            ['first_name', 'First Name', '(Required)', 'Needed to identify the contact'],
            ['last_name', 'Last Name', '(Required)', ''],
            ['full_name', 'Full Name', '(Optional)', 'Auto-generated if left blank'],
            ['tax_id_type', 'Tax ID Type', '(Optional)', 'Specifies the type of tax identification'],
            ['tax_id_number', 'Tax ID Number', '(Optional)', ''],
            ['tax_name', 'Tax Name', '(Optional)', ''],
            ['email', 'Email', '(Optional)', ''],
            ['phone_mobile', 'Mobile Phone', '(Optional)', 'Mobile phone is optional'],
            ['phone_landline', 'Landline Phone', '(Optional)', ''],
            ['phone_alternate', 'Alternate Phone', '(Optional)', ''],
            ['address_line_1', 'Address Line 1', '(Optional)', ''],
            ['address_line_2', 'Address Line 2', '(Optional)', ''],
            ['city', 'City', '(Optional)', ''],
            ['state', 'State', '(Optional)', ''],
            ['country', 'Country', '(Optional)', ''],
            ['zip_code', 'Zip Code', '(Optional)', ''],
            ['opening_balance', 'Opening Balance', '(Optional)', ''],
            ['credit_limit', 'Credit Limit', '(Optional)', ''],
            ['payment_term_value', 'Payment Term', '(Required if supplier)', ''],
            ['payment_term_type', 'Payment Term Period', '(Required if supplier)', 'Options: days or months'],
        ];

        return view('livewire.contacts.import-contact.index', [
            'columnas' => $fields,
        ]);
    }
}
