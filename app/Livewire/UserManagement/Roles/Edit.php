<?php

namespace App\Livewire\UserManagement\Roles;

use App\Helpers\ToastHelper;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Traits\InteractsWithToasts;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    use InteractsWithToasts;

    public $idRole;
    public $name;
    public $confirmingUserDeletion = false;
    public $selectedPermissions = [];
    public Role $role;

    public function mount(Role $role)
    {
        $this->role = $role->load('permissions');
        $this->authorize('update', $this->role);
        $this->idRole = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function render()
    {
        $permissions = Permission::all();

        // Agrupar directamente por la columna 'module'
        $modules = $permissions->groupBy('module');
        return view('livewire.user-management.roles.edit', compact('modules'));
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($this->idRole),
            ],
            'selectedPermissions' => 'nullable|array',
            'selectedPermissions.*' => 'exists:permissions,id',
        ];
    }

    public function update()
    {
        $this->authorize('update', $this->role);

        try {
            $this->validate();

            $original = $this->role->getOriginal();

            $originalPermissions = $this->role->permissions()->pluck('id')->toArray();
            $newPermissions = $this->selectedPermissions;

            // Convertir a nombres
            $beforeNames = Permission::whereIn('id', $originalPermissions)->pluck('name')->toArray();
            $afterNames = Permission::whereIn('id', $newPermissions)->pluck('name')->toArray();


            $this->role->name = $this->name;
            $this->role->save();

            $this->role->permissions()->sync($this->selectedPermissions);

            logActivity(
                'update',
                $this->role,
                [
                    'action' => 'update',
                    'entity' => 'role',
                    'before' => array_merge(
                        collect($original)->only(['name'])->toArray(),
                        ['permissions_assigned' => $beforeNames]
                    ),
                    'after' => array_merge(
                        collect($this->role->getChanges())->only(['name'])->toArray(),
                        ['permissions_assigned' => $afterNames]
                    ),
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'Role was updated.'
            );

            ToastHelper::flashSuccess('The role has been updated successfully.', 'Success');
            return redirect()->route('user-management.roles.index');
        } catch (\Throwable $e) {
            report($e);
            $this->showToastError('An error occurred while updating the role: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        $this->authorize('delete', $this->role);

        if ($this->role->name === 'admin' || $this->role->name === 'super admin') {
            $this->showToastError('The admin role cannot be deleted.');
            return;
        }

        try {
            $roleData = $this->role->toArray();

            $this->role->syncPermissions([]);
            $this->role->delete();

            logActivity(
                'delete',
                $this->role,
                [
                    'action' => 'delete',
                    'entity' => 'role',
                    'before' => $roleData, // Aquí puedes guardar toda la información antes de la eliminación
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'Role was deleted.'
            );

            $this->showToastSuccess('Role deleted successfully.');
            return redirect()->route('user-management.roles.index');
        } catch (\Throwable $e) {
            report($e);
            $this->showToastError('An error occurred while deleting the role: ' . $e->getMessage());
        }
    }

    public function closeDelete()
    {
        $this->confirmingUserDeletion = false;
    }
}
