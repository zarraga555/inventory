<?php

namespace App\Livewire\UserManagement\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $roles = Role::query()
        ->where('name', 'like', "%{$this->search}%")
        ->orWhere('email', 'like', "%{$this->search}%")
        ->orderBy('created_at', 'desc')
        ->paginate(25);

        return view('livewire.user-management.roles.index', compact('roles'));
    }
}
