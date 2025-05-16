<?php

namespace App\Livewire\Contacts\Customer;

use Livewire\Component;
use App\Models\Contact;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\InteractsWithToasts;
use App\Helpers\ToastHelper;

class Edit extends Component
{
    use InteractsWithToasts;

    public Contact $contact;
    public $customerGroups;
    public $show = false;
    public $confirmingCustomerDeletion = false;
    public $title = "customer";

    // Contact details
    public $tax_id_type;
    public $tax_id_number;
    public $tax_name;
    public $company_name;
    public $first_name;
    public $last_name;

    // Contact information
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
    private string $redirectRoute = 'contacts.customer.index';
    private int $bussiness_id = 1;
    private string $type = 'customer';

    protected function rules()
    {
        return [
            'tax_id_type' => 'required|in:CI,NIT,CEX,PAS',
            'tax_id_number' => 'required|unique:contacts,tax_id_number,' . $this->contact->id,
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


    public function mount(Contact $customer)
    {
        $this->authorize('update', $customer);
        $this->contact = $customer;
        $this->customerGroups = CustomerGroup::all();
        $this->fillFromContact();
    }

    private function fillFromContact()
    {
        $this->tax_id_type = $this->contact->tax_id_type;
        $this->tax_id_number = $this->contact->tax_id_number;
        $this->tax_name = $this->contact->tax_name;
        $this->company_name = $this->contact->company_name;
        $this->first_name = $this->contact->first_name;
        $this->last_name = $this->contact->last_name;
        $this->email = $this->contact->email;
        $this->phone_mobile = $this->contact->phone_mobile;
        $this->phone_landline = $this->contact->phone_landline;
        $this->phone_alternate = $this->contact->phone_alternate;
        $this->address_line_1 = $this->contact->address_line_1;
        $this->address_line_2 = $this->contact->address_line_2;
        $this->city = $this->contact->city;
        $this->state = $this->contact->state;
        $this->country = $this->contact->country;
        $this->zip_code = $this->contact->zip_code;
        $this->opening_balance = $this->contact->opening_balance;
        $this->credit_limit = $this->contact->credit_limit;
        $this->payment_term_value = $this->contact->payment_term_value;
        $this->payment_term_type = $this->contact->payment_term_type;
        $this->customer_group_id = $this->contact->customer_group_id;
    }


    public function update()
    {
        $this->authorize('update', $this->contact);

        $validated = $this->validate();

        DB::beginTransaction();

        try {
            $before = $this->contact->toArray();

            $this->contact->update([
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

            logActivity('update', $this->contact, [
                'action' => 'update',
                'entity' => 'contact',
                'before' => $before,
                'after' => $this->contact->toArray(),
                'performed_by' => Auth::user()?->only(['id', 'name', 'email']),
            ], 'Customer was updated.');

            DB::commit();

            ToastHelper::flashSuccess('The customer was successfully updated.', 'Updated');
            return redirect()->route($this->redirectRoute);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showToastError('An error occurred while updating the customer. ' . $e->getMessage());
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
        $this->authorize('delete', $this->contact);

        try {
            $customer = $this->contact; 
            $userData = $customer->toArray(); 

            $customer->delete();

            logActivity(
                'delete',
                $customer,
                [
                    'action' => 'delete',
                    'entity' => 'contact',
                    'before' => $userData,
                    'performed_by' => Auth::user()?->only(['id', 'name', 'email']),
                ],
                'Customer was deleted.'
            );

            ToastHelper::flashSuccess('The customer was successfully deleted.', 'Success');

            return redirect()->route($this->redirectRoute); // Mismo redirect que en tu create
        } catch (\Throwable $e) {
            report($e);
            ToastHelper::flashError('An error occurred while deleting the customer. ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->authorize('update', $this->contact);
        return view('livewire.contacts.customer.edit');
    }
}
