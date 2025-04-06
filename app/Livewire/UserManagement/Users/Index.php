<?php

namespace App\Livewire\UserManagement\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

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
        $users = User::query()
        ->where('name', 'like', "%{$this->search}%")
        ->orWhere('email', 'like', "%{$this->search}%")
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.user-management.users.index', compact('users'));
    }
}
