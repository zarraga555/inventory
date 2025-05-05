<?php

namespace App\Livewire\UserManagement\Users;

use App\Helpers\ToastHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Traits\InteractsWithToasts;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    use InteractsWithToasts;

    public $name, $email, $password, $password_confirmation, $availableRoles, $selectedRoleId;
    public $confirmingUserDeletion = false;
    public $userId;
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user->load('roles');
        $this->authorize('update', $this->user);
        $this->userId = $user->id;
        $this->availableRoles = Role::all();
        $this->selectedRoleId = $user->roles->pluck('id')->first() ?? 0;
        $this->name = $user->name;
        $this->email = $user->email;
    }


    public function render()
    {
        // $this->authorize('view', $this->user);
        return view('livewire.user-management.users.edit');
    }

    private function validateForm()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->userId) // Ignora el email del usuario actual
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Permite que la contraseña sea opcional en la actualización
            'selectedRoleId' => ['required', Rule::exists('roles', 'id')],
        ]);
    }

    /**
     * Actualiza el registro en la base de datos.
     */
    public function update()
    {
        $this->authorize('update', $this->user);

        try {
            $this->validateForm();
            $this->updateItem();

            ToastHelper::flashSuccess('The user has been updated successfully.', 'Success');
            return redirect()->route('user-management.users.index');
        } catch (\Throwable $e) {
            // Puedes guardar el error en logs también si deseas
            report($e);
            ToastHelper::flashError('An error occurred while updating the user. Please try again. ' . $e->getMessage());
        }
    }

    private function updateItem()
    {
        $role = Role::find($this->selectedRoleId);
        if (!$role) {
            ToastHelper::flashError('The selected role is invalid. Please choose a valid role.');
            return;
        }

        $user = User::findOrFail($this->userId);

        $original = $user->getOriginal(); // Capturamos los valores originales antes del update

        $user->name = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $user->roles()->sync([$role->id]);

        logActivity(
            'update',
            $user,
            [
                'action' => 'update',
                'entity' => 'user',
                'before' => collect($original)->only(['name', 'email']),
                'after' => collect($user->getChanges())->only(['name', 'email']),
                'performed_by' => Auth::user()->only(['id', 'name', 'email']),
            ],
            'User information was updated.'
        );
    }

    /**
     * Elimina el registro de la base de datos.
     */
    public function delete()
    {
        $this->authorize('delete', $this->user);

        // Evita que un usuario elimine su propia cuenta mientras está logueado
        if (Auth::id() === $this->user->id) {
            $this->confirmingUserDeletion = false; // Cierra el modal de confirmación de borrado
            $this->showToastError('You cannot delete your own account while logged in.');
            return;
        }

        try {
            $user = User::findOrFail($this->userId);
            $userData = $user->toArray(); // Guardamos la data antes de eliminar

            $user->delete();

            logActivity(
                'delete',
                $user,
                [
                    'action' => 'delete',
                    'entity' => 'user',
                    'before' => $userData, // toda la info eliminada
                    'performed_by' => Auth::user()->only(['id', 'name', 'email']),
                ],
                'User was deleted.'
            );

            ToastHelper::flashSuccess('User has been successfully deleted.', 'Success');

            return redirect()->route('user-management.users.index');
        } catch (\Throwable $e) {
            report($e);
            ToastHelper::flashError('An error occurred while deleting the user. ' . $e->getMessage());
        }
    }
}
