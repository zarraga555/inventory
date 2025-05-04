<?php

namespace App\Livewire\UserManagement\Roles;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\InteractsWithToasts;
use App\Helpers\ToastHelper;

class Create extends Component
{
    use InteractsWithToasts;

    public string $name = '';
    public array $selectedPermissions = [];

    protected array $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
        'selectedPermissions' => 'nullable|array',
        'selectedPermissions.*' => 'exists:permissions,id',
    ];

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->selectedPermissions = [];
    }

    private function createRole(bool $redirectAfterSave = true)
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // Crear el rol
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => 'web',
            ]);

            // Asignar permisos
            if (!empty($this->selectedPermissions)) {
                $role->permissions()->sync($this->selectedPermissions);
            }

            // Registrar en logs (opcional, si usás ActivityLogHelper o logActivity)
            logActivity(
                'create',
                $role,
                [
                    'action' => 'create',
                    'entity' => 'role',
                    'after' => $role->only(['id', 'name']),
                    'permissions_assigned' => $this->selectedPermissions, // Si estás guardando permisos
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'Role was created.'
            );

            DB::commit();

            $this->resetInputFields();

            if ($redirectAfterSave) {
                ToastHelper::flashSuccess('Role successfully created.', 'Saved');
                return redirect()->route('user-management.roles.index');
            } else {
                $this->showToastSuccess('Role successfully created.', 'Saved');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating role: ' . $e->getMessage());
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    public function save(): void
    {
        $this->authorize('create', Role::class);
        $this->createRole(true);
    }
    
    public function saveAndCreateAnother(): void
    {
        $this->authorize('create', Role::class);
        $this->createRole(false);
    }
    
    public function render()
    {
        $this->authorize('create', Role::class);

        $permissions = Permission::all();

        // Agrupar directamente por la columna 'module'
        $modules = $permissions->groupBy('module');
    
        return view('livewire.user-management.roles.create', compact('modules'));
    }
}