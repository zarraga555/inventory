<?php

namespace App\Livewire\UserManagement\Users;

use App\Models\User;
use Livewire\Component;
use App\Helpers\ToastHelper;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Traits\InteractsWithToasts;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use InteractsWithToasts;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $selectedRoleId;
    public $availableRoles;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'selectedRoleId' => 'required|exists:roles,id',
    ];

    /**
     * Resetea los campos del formulario.
     */
    private function resetInputFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRoleId = '';
    }

    /**
     * Método común para guardar el usuario.
     */
    private function saveUser($redirectAfterSave = true)
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // Crear el usuario
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Asignar el rol
            $user->roles()->sync($this->selectedRoleId);

            // Registrar el activity log
            logActivity(
                'create',
                $user,
                [
                    'action' => 'create',
                    'entity' => 'user',
                    'after' => $user->only(['id', 'name', 'email']),
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'User was created.'
            );

            DB::commit();

            // Resetear campos
            $this->resetInputFields();

            // Mostrar mensaje de éxito
            if ($redirectAfterSave) {
                // Si redirige después de guardar
                ToastHelper::flashSuccess('The user was successfully registered.', 'Saved');
                return redirect()->route('user-management.users.index');
            } else {
                // Si no redirige (para crear otro)
                $this->showToastSuccess('The user was successfully registered.', 'Saved');
            }
        } catch (\Exception $e) {
            DB::rollback();

            // Mostrar mensaje de error
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    /**
     * Guarda el usuario y redirige al índice.
     */
    public function save()
    {
        $this->authorize('create', User::class);
        $this->saveUser(true);
    }

    /**
     * Guarda el usuario y mantiene el formulario limpio para agregar otro.
     */
    public function saveAndCreateAnother()
    {
        $this->authorize('create', User::class);
        $this->saveUser(false);
    }

    /**
     * Renderiza la vista.
     */
    public function render()
    {
        $this->authorize('create', User::class);

        $this->availableRoles = Role::all();
        return view('livewire.user-management.users.create');
    }
}
