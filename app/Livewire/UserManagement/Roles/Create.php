<?php

namespace App\Livewire\UserManagement\Roles;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Helpers\ToastHelper;
use Illuminate\Support\Facades\Log;
use App\Traits\InteractsWithToasts;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    use InteractsWithToasts;

    public string $name; // Nombre del rol
    public $selectedPermissions = []; // Permisos seleccionados

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name', // Validación para el nombre del rol
        'selectedPermissions' => 'nullable|array', // Asegurar que selectedPermissions sea un arreglo
        'selectedPermissions.*' => 'exists:permissions,id', // Asegurarse de que cada permiso existe en la tabla 'permissions'
    ];

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->selectedPermissions = [];
    }

    private function createItem()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            // Crear el rol
            $role = \Spatie\Permission\Models\Role::create(['name' => $this->name, 'guard_name' => 'web']);

            // Asignar los permisos seleccionados al rol
            if (count($this->selectedPermissions)) {
                $role->permissions()->sync($this->selectedPermissions);
            }

            // Confirmar la transacción
            DB::commit();

            // Limpiar el formulario
            $this->reset();

            return $role;
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollback();
            // Registrar el error para depuración
            Log::error('Error al crear rol: ' . $e->getMessage());
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    public function save()
    {
        try {
            $this->createItem();
            ToastHelper::flashSuccess('Role successfully created.', 'Saved');
            return redirect()->route('user-management.roles.index');
        } catch (\Exception $e) {
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    public function saveAndCreateAnother()
    {
        try {
            $this->createItem();
            $this->showToastSuccess('Role successfully created.', 'Saved');
            $this->resetInputFields();
        } catch (\Exception $e) {
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Obtener todos los permisos
        $permissions = Permission::all();

        // Agrupar los permisos por módulo
        $modules = $permissions->groupBy(function ($permission) {
            // Extraer el nombre del módulo (por ejemplo, "Usuarios" de "crear usuarios")
            $parts = explode(' ', $permission->name);

            // Extraer todo después de la primera palabra (el verbo)
            array_shift($parts); // Eliminar el verbo (la primera palabra)

            // Usar el resto de las palabras como el nombre del módulo
            return ucfirst(implode(' ', $parts));  // Unir el resto y capitalizar
        });
        return view('livewire.user-management.roles.create', compact('modules'));
    }
}
