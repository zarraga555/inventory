<?php

namespace App\Livewire\UserManagement\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function getQueryProperty()
    {
        return User::query()
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $this->authorize('viewAny', User::class);
        return view('livewire.user-management.users.index', [
            'users' => $this->query->paginate(25),
        ]);
    }
}