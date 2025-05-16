<?php

namespace App\Livewire\Contacts\Supplier;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\InteractsWithToasts;
use App\Helpers\ToastHelper;

class Edit extends Component
{
    use InteractsWithToasts;

    public Supplier $supplier;
    public $customerGroups;
    public $show = false;
    public $confirmingCustomerDeletion = false;
    public $title = "supplier";

    // Supplier details
    public $tax_id_type;
    public $tax_id_number;
    public $tax_name;
    public $company_name;
    public $first_name;
    public $last_name;

    // Supplier information
    public $email;
    public $phone_mobile;
    public $phone_landline;
    public $phone_alternate;

    // Address
    public $address_line_1;
    public $address_line_2;
    public $city;
    public $state;
    public $country;
    public $zip_code;

    // Financial data
    public $opening_balance;
    public $credit_limit;
    public $payment_term_value;
    public $payment_term_type;
    public $customer_group_id;

    // Backend
    private string $redirectRoute = 'contacts.supplier.index';
    private int $bussiness_id = 1;
    private string $type = 'supplier';

    protected function rules()
    {
        return [
            'tax_id_type' => 'required|in:CI,NIT,CEX,PAS',
            'tax_id_number' => 'required|unique:contacts,tax_id_number,' . $this->supplier->id,
            'tax_name' => 'nullable|string',
            'company_name' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'phone_mobile' => 'nullable|string',
            'phone_landline' => 'nullable|string',
            'phone_alternate' => 'nullable|string',
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'opening_balance' => 'nullable',
            'credit_limit' => 'nullable',
            'payment_term_value' => 'nullable|integer',
            'payment_term_type' => 'nullable|in:days,months',
            'customer_group_id' => 'nullable|exists:customer_groups,id',
        ];
    }

    public function mount(Supplier $supplier)
    {
        $this->authorize('update', $supplier);
        $this->supplier = $supplier;
        $this->customerGroups = CustomerGroup::all();
        $this->fillFromContact();
    }

    private function fillFromContact()
    {
        $this->tax_id_type = $this->supplier->tax_id_type;
        $this->tax_id_number = $this->supplier->tax_id_number;
        $this->tax_name = $this->supplier->tax_name;
        $this->company_name = $this->supplier->company_name;
        $this->first_name = $this->supplier->first_name;
        $this->last_name = $this->supplier->last_name;
        $this->email = $this->supplier->email;
        $this->phone_mobile = $this->supplier->phone_mobile;
        $this->phone_landline = $this->supplier->phone_landline;
        $this->phone_alternate = $this->supplier->phone_alternate;
        $this->address_line_1 = $this->supplier->address_line_1;
        $this->address_line_2 = $this->supplier->address_line_2;
        $this->city = $this->supplier->city;
        $this->state = $this->supplier->state;
        $this->country = $this->supplier->country;
        $this->zip_code = $this->supplier->zip_code;
        $this->opening_balance = $this->supplier->opening_balance;
        $this->credit_limit = $this->supplier->credit_limit;
        $this->payment_term_value = $this->supplier->payment_term_value;
        $this->payment_term_type = $this->supplier->payment_term_type;
        $this->customer_group_id = $this->supplier->customer_group_id;
    }

    public function update()
    {
        $this->authorize('update', $this->supplier);

        $validated = $this->validate();

        DB::beginTransaction();

        try {
            $before = $this->supplier->toArray();

            $this->supplier->update([
                'company_name' => $this->company_name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'full_name' => trim($this->first_name . ' ' . $this->last_name),
                'tax_id_type' => $this->tax_id_type,
                'tax_id_number' => $this->tax_id_number,
                'tax_name' => $this->tax_name,
                'email' => $this->email,
                'phone_mobile' => $this->phone_mobile,
                'phone_landline' => $this->phone_landline,
                'phone_alternate' => $this->phone_alternate,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country ?: 'Bolivia',
                'zip_code' => $this->zip_code,
                'opening_balance' => $this->opening_balance !== '' ? (float) $this->opening_balance : 0.00,
                'credit_limit' => $this->credit_limit !== '' ? (float) $this->credit_limit : null,
                'payment_term_value' => $this->payment_term_value !== '' ? (int) $this->payment_term_value : null,
                'payment_term_type' => $this->payment_term_type ?: null,
                'customer_group_id' => $this->customer_group_id ?: null,
            ]);

            logActivity('update', $this->supplier, [
                'action' => 'update',
                'entity' => 'supplier',
                'before' => $before,
                'after' => $this->supplier->toArray(),
                'performed_by' => Auth::user()?->only(['id', 'name', 'email']),
            ], 'Supplier was updated.');

            DB::commit();

            ToastHelper::flashSuccess('The supplier was successfully updated.', 'Updated');
            return redirect()->route($this->redirectRoute);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showToastError('An error occurred while updating the supplier. ' . $e->getMessage());
        }
    }

    public function showEntries()
    {
        $this->show = true;
    }

    public function hideEntries()
    {
        $this->show = false;
    }

    public function delete()
    {
        $this->authorize('delete', $this->supplier);

        try {
            $supplier = $this->supplier; 
            $userData = $supplier->toArray(); 

            $supplier->delete();

            logActivity(
                'delete',
                $supplier,
                [
                    'action' => 'delete',
                    'entity' => 'supplier',
                    'before' => $userData,
                    'performed_by' => Auth::user()?->only(['id', 'name', 'email']),
                ],
                'Supplier was deleted.'
            );

            ToastHelper::flashSuccess('The supplier was successfully deleted.', 'Success');

            return redirect()->route($this->redirectRoute); // Mismo redirect que en tu create
        } catch (\Throwable $e) {
            report($e);
            ToastHelper::flashError('An error occurred while deleting the supplier. ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->authorize('update', $this->supplier);
        return view('livewire.contacts.supplier.edit');
    }
}
