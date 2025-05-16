<?php

namespace App\Livewire\Contacts\Customer;

use Livewire\Component;
use App\Models\Contact;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\InteractsWithToasts;
use App\Helpers\ToastHelper;


class Create extends Component
{
    use InteractsWithToasts;

    public $customerGroups;
    public $show = false;

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

    protected array $rules = [
        'tax_id_type' => 'required|in:CI,NIT,CEX,PAS',
        'tax_id_number' => 'required|unique:contacts,tax_id_number',
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

    public function mount()
    {
        // $this->authorize('create', Contact::class);
        $this->customerGroups = CustomerGroup::all();
    }

    private function resetInputFields(): void
    {
        $this->reset([
            'tax_id_type',
            'tax_id_number',
            'tax_name',
            'company_name',
            'first_name',
            'last_name',
            'email',
            'phone_mobile',
            'phone_landline',
            'phone_alternate',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'country',
            'zip_code',
            'opening_balance',
            'credit_limit',
            'payment_term_value',
            'payment_term_type',
            'customer_group_id'
        ]);
    }

    private function saveContact($redirectAfterSave = true)
    {
        $this->validate();

        DB::beginTransaction();

        try {
            // return dd($this);
            $customer = Contact::create([
                'business_id' => $this->bussiness_id,
                'type' => $this->type,
                'created_by' => Auth::id(),

                // Basic information
                'company_name' => $this->company_name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'full_name' => trim($this->first_name . ' ' . $this->last_name),

                // Tax document
                'tax_id_type' => $this->tax_id_type,
                'tax_id_number' => $this->tax_id_number,
                'tax_name' => $this->tax_name,

                // Contact
                'email' => $this->email,
                'phone_mobile' => $this->phone_mobile,
                'phone_landline' => $this->phone_landline,
                'phone_alternate' => $this->phone_alternate,

                // Address
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country ?: 'Bolivia',
                'zip_code' => $this->zip_code,

                // Financial data
                'opening_balance' => $this->opening_balance !== '' ? (float) $this->opening_balance : 0.00,
                'credit_limit' => $this->credit_limit !== '' ? (float) $this->credit_limit : null,
                'payment_term_value' => $this->payment_term_value !== '' ? (int) $this->payment_term_value : null,
                'payment_term_type' => $this->payment_term_type ?: null,

                // Customer group
                'customer_group_id' => $this->customer_group_id ?: null,
            ]);

            // Register activity
            logActivity('create', $customer, [
                'action' => 'create',
                'entity' => 'contact',
                'after' => $customer->toArray(),
                'performed_by' => Auth::user()?->only(['id', 'name', 'email']),
            ], 'Customer was created.');

            DB::commit();

            $this->resetInputFields();

            if ($redirectAfterSave) {
                ToastHelper::flashSuccess('The customer was successfully registered.', 'Saved');
                return redirect()->route($this->redirectRoute);
            } else {
                $this->showToastSuccess('The customer was successfully registered.', 'Saved');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showToastError('An error occurred while saving the customer. ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->authorize('create', Contact::class);
        $this->saveContact(true);
    }

    public function saveAndCreateAnother()
    {
        $this->authorize('create', Contact::class);
        $this->saveContact(false);
    }

    public function showEntries()
    {
        $this->show = true;
    }

    public function hideEntries()
    {
        $this->show = false;
    }

    public function render()
    {
        $this->authorize('create', Contact::class);
        return view('livewire.contacts.customer.create');
    }
}
//2618thh