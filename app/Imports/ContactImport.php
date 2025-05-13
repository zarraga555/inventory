<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class ContactImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        return new Contact([
            'type' => $row['type'],
            'company_name' => $row['company_name'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'full_name' => $row['full_name'] ?? $row['first_name'] . ' ' . $row['last_name'],
            'tax_id_type' => $row['tax_id_type'],
            'tax_id_number' => $row['tax_id_number'],
            'tax_name' => $row['tax_name'],
            'email' => isset($row['email']) ? trim($row['email']) : null,
            'phone_mobile' => $row['phone_mobile'],
            'phone_landline' => $row['phone_landline'],
            'phone_alternate' => $row['phone_alternate'],
            'address_line_1' => $row['address_line_1'],
            'address_line_2' => $row['address_line_2'],
            'city' => $row['city'],
            'state' => $row['state'],
            'country' => $row['country'],
            'zip_code' => $row['zip_code'],
            'opening_balance' => $row['opening_balance'],
            'credit_limit' => $row['credit_limit'],
            'payment_term_value' => $row['payment_term_value'],
            'payment_term_type' => $row['payment_term_type'],
        ]);
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:1,2,3',
            'company_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'payment_term_type' => 'nullable|in:days,months',
            // more validation rules...
        ];
    }

    public function customValidationMessages()
    {
        return [
            'type.required' => 'El tipo de contacto es obligatorio.',
            'type.in' => 'El tipo de contacto debe ser 1 (Cliente), 2 (Proveedor) o 3 (Ambos).',
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
        ];
    }
}
