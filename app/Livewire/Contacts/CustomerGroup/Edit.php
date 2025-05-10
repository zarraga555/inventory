<?php

namespace App\Livewire\Contacts\CustomerGroup;

use App\Helpers\ToastHelper;
use App\Models\CustomerGroup;
use Livewire\Component;
use App\Traits\InteractsWithToasts;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    use InteractsWithToasts;

    // Frontend
    public string $name = '';
    public string $amount = '';
    public CustomerGroup $customerGroup;
    public $confirmingCustomerGroupsDeletion = false;

    // Backend
    private string $price_calculation_type = 'percentage';
    private int $business_id = 1;
    private string $redirectRoute = 'contacts.customer-group.index';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'amount' => 'required|string|numeric|max:255',
    ];

    public function mount(CustomerGroup $customerGroup)
    {
        $this->customerGroup = $customerGroup; // Primero asigna
        $this->authorize('update', $this->customerGroup); // Luego autoriza
        $this->name = $customerGroup->name;
        $this->amount = $customerGroup->amount;
    }

    public function render()
    {
        return view('livewire.contacts.customer-group.edit');
    }

    public function update()
    {
        $this->authorize('update', $this->customerGroup);

        try {
            $this->validate();
            $this->updateItem();

            ToastHelper::flashSuccess('The customer group has been updated successfully.', 'Success');
            return redirect()->route($this->redirectRoute);
        } catch (\Throwable $e) {
            // Puedes guardar el error en logs también si deseas
            report($e);
            ToastHelper::flashError('An error occurred while updating the customer group. Please try again. ' . $e->getMessage());
        }
    }

    private function updateItem()
    {
        $customer_group = CustomerGroup::find($this->customerGroup->id);
        if (!$customer_group) {
            ToastHelper::flashError('The selected customer group is invalid. Please choose a valid customer group.');
            return;
        }

        $original = $customer_group->getOriginal(); // Capturamos los valores originales antes del update

        $customer_group->name = $this->name;
        $customer_group->amount = $this->amount;
        $customer_group->price_calculation_type = $this->price_calculation_type;
        $customer_group->business_id = $this->business_id;

        $customer_group->save();


        logActivity(
            'update',
            $customer_group,
            [
                'action' => 'update',
                'entity' => 'CustomerGroup',
                'before' => collect($original)->toArray(),
                'after' => collect($customer_group->getChanges())->toArray(),
                'performed_by' => Auth::user()->only(['id', 'name', 'email']),
            ],
            'Customer Group information was updated.'
        );
    }

    public function delete()
    {
        $this->authorize('delete', $this->customerGroup);

        try {
            $customerGroup = $this->customerGroup; // Ya tienes el modelo cargado
            $userData = $customerGroup->toArray(); // Guardamos la data antes de eliminar

            $customerGroup->delete();

            logActivity(
                'delete',
                $customerGroup,
                [
                    'action' => 'delete',
                    'entity' => 'CustomerGroup',
                    'before' => $userData, // toda la info eliminada
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'Customer Group was deleted.'
            );

            ToastHelper::flashSuccess('Customer Group has been successfully deleted.', 'Success');

            return redirect()->route($this->redirectRoute);
        } catch (\Throwable $e) {
            report($e);
            ToastHelper::flashError('An error occurred while deleting the user. ' . $e->getMessage());
        }
    }
}
