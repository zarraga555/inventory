<?php

namespace App\Livewire\UserManagement\Users;

use App\Helpers\ToastHelper;
use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public $name, $email, $password, $password_confirmation, $roles, $user_type;
    public $confirmingUserDeletion = false;
    public $user_id;
    public $nameLabel;

    public function mount($user)
    {
        $user = User::findOrFail($user);

        $this->roles = Role::all();
        $this->user_type = isset($user->roles->pluck('id')[0]) ? $user->roles->pluck('id')[0] : 0;
        $this->nameLabel = $user->name;
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function render()
    {
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
                Rule::unique('users', 'email')->ignore($this->user_id) // Ignora el email del usuario actual
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Permite que la contraseña sea opcional en la actualización
        ]);
    }

    /**
     * Actualiza el registro en la base de datos.
     */
    public function update()
    {
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
        $user = User::findOrFail($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $user->roles()->sync([$this->user_type]); // <-- Verifica que este campo esté correctamente mapeado
    }

    /**
     * Elimina el registro de la base de datos.
     */
    public function delete()
    {
        User::findOrFail($this->user_id)->delete();

        $this->closeDelete();

        ToastHelper::flashSuccess('User has been successfully deleted.', 'Success');

        return redirect()->route('user-management.users.index');
    }
}
