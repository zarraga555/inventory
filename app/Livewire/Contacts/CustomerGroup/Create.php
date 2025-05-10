<?php

namespace App\Livewire\Contacts\CustomerGroup;

use Livewire\Component;
use App\Helpers\ToastHelper;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\DB;
use App\Traits\InteractsWithToasts;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use InteractsWithToasts;

    public string $name = '';
    public string $amount = '';
    private string $price_calculation_type = 'percentage';
    private int $business_id = 1;
    private string $redirectRoute = 'contacts.customer-group.index';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'amount' => 'required|string|numeric|max:255',
    ];

    private function resetInputFields(): void
    {
        $this->reset([
            'name',
            'amount',
        ]);
    }

    private function saveCustomerGroup($redirectAfterSave = true)
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // Crear el usuario
            $customer_group = CustomerGroup::create([
                'business_id' => $this->business_id,
                'name' => $this->name,
                'amount' => $this->amount,
                'price_calculation_type' => $this->price_calculation_type,
                'created_by' => Auth::id(),
            ]);

            // Registrar el activity log
            logActivity(
                'create',
                $customer_group,
                [
                    'action' => 'create',
                    'entity' => 'CustomerGroup',
                    'after' => $customer_group->toArray(),
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'Customer group was created.'
            );

            DB::commit();

            // Resetear campos
            $this->resetInputFields();

            // Mostrar mensaje de éxito
            if ($redirectAfterSave) {
                // Si redirige después de guardar
                ToastHelper::flashSuccess('The customer group was successfully registered.', 'Saved');
                return redirect()->route($this->redirectRoute);
            } else {
                // Si no redirige (para crear otro)
                $this->showToastSuccess('The customer group was successfully registered.', 'Saved');
            }
        } catch (\Exception $e) {
            DB::rollback();

            // Mostrar mensaje de error
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->authorize('create', CustomerGroup::class);
        $this->saveCustomerGroup(true);
    }

    public function saveAndCreateAnother()
    {
        $this->authorize('create', CustomerGroup::class);
        $this->saveCustomerGroup(false);
    }

    public function render()
    {
        $this->authorize('create', CustomerGroup::class);
        return view('livewire.contacts.customer-group.create');
    }
}
