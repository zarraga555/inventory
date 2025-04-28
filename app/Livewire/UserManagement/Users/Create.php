<?php

namespace App\Livewire\UserManagement\Users;

use App\Models\User;
use Livewire\Component;
use App\Helpers\ToastHelper;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Traits\InteractsWithToasts;
use Illuminate\Support\Facades\Hash;


class Create extends Component
{
    use InteractsWithToasts;

    public string $name;
    public string $email;
    public string $password;
    public string $password_confirmation;
    public $selectedRoleId, $availableRoles;

    public array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'selectedRoleId' => 'required|integer|in:1,2',
    ];

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRoleId = '';
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->createItem();
            DB::commit();
            $this->resetInputFields();
            ToastHelper::flashSuccess('The user was successfully registered.', 'Saved');
            return redirect()->route('user-management.users.index');
        } catch (\Exception $e) {
            DB::rollback();
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
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
            $this->showToastSuccess('The user was successfully registered.', 'Saved');
        } catch (\Exception $e) {
            DB::rollback();
            $this->showToastError('An error occurred while saving. ' . $e->getMessage());
        }
    }

    private function createItem()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        $user->roles()->sync($this->selectedRoleId);
        logActivity(
            'create',
            $user,
            [
                'created_user' => $user->only(['id', 'name', 'email']),
                'performed_by' => auth()->user()->only(['id', 'name', 'email']),
            ],
            'User was created.'
        );
    }

    public function render()
    {
        $this->availableRoles = Role::all();
        return view('livewire.user-management.users.create');
    }
}
