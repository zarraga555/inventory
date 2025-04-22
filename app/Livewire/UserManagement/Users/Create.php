<?php

namespace App\Livewire\UserManagement\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public string $name;
    public string $email;
    public string $password;
    public string $password_confirmation;
    public $user_type, $roles;

    public array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'user_type' => 'required|integer|in:1,2',
    ];

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->user_type = '';
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->createItem();
            DB::commit();
            $this->resetInputFields();
            // Guardar el mensaje en la sesión
            session()->flash('toast', [
                'type' => 'success',
                'title' => __('Saved'), // ← este debe estar presente
                'message' => __('The user was successfully registered.'),
            ]);
            return redirect()->route('user-management.users.index');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => __('Error'), // ← este debe estar presente
                'message' => __('An error occurred while saving.'). $e->getMessage(),
            ]);
        }
    }

    public function saveAndCreateAnother()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->createItem();
            DB::commit();
            $this->resetInputFields();

            // Emitir evento para mostrar toast
            $this->dispatch('show-toast', [
                'type' => 'success',
                'title' => __('Saved'), // ← este debe estar presente
                'message' => __('The user was successfully registered.'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => __('Error'), // ← este debe estar presente
                'message' => __('An error occurred while saving.'). $e->getMessage(),
            ]);
        }
    }

    private function createItem()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        $user->assignRole($this->user_type);
    }

    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.user-management.users.create');
    }
}
