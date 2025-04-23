<?php

namespace App\Livewire\UserManagement\Users;

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

    public function render()
    {
        return view('livewire.user-management.users.edit');
    }

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
        $this->validateForm();

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        //$user->roles()->sync($this->role_id);

        session()->flash('toast', [
            'type' => 'success',
            'title' => __('Success'), // ← este debe estar presente
            'message' => __('The user has been updated successfully.'),
        ]);

        return redirect()->route('user-management.users.index');
    }

    /**
     * Elimina el registro de la base de datos.
     */
    public function delete()
    {
        User::findOrFail($this->user_id)->delete();

        $this->closeDelete();

        session()->flash('toast', [
            'type' => 'success',
            'title' => __('Success'), // ← este debe estar presente
            'message' => __('User has been successfully deleted.'),
        ]);
        return redirect()->route('user-management.users.index');
    }
}
