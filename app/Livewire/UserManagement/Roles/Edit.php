<?php

namespace App\Livewire\UserManagement\Roles;

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
        $modules = $permissions->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            array_shift($parts);
            return ucfirst(implode(' ', $parts));
        });

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

            $this->role->name = $this->name;
            $this->role->save();

            $this->role->syncPermissions($this->selectedPermissions);

            logActivity(
                'update',
                $this->role,
                [
                    'before' => collect($original)->only(['name']),
                    'after' => collect($this->role->getChanges())->only(['name']),
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'Role was updated.'
            );

            $this->showToastSuccess('Role updated successfully.');
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
                    'deleted_role' => $roleData,
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