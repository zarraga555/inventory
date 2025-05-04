<?php

namespace App\Livewire\UserManagement\Logs;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\ActivityLog;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public User $user;
    public $selectedChanges = [];

    public function showChanges($logId)
    {
        $log = \App\Models\ActivityLog::findOrFail($logId);
        $this->selectedChanges = $log->changes;
    }

    public function mount(User $user)
    {
        // return dd($user);
        $this->user = $user;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }


    public function render()
    {
        $logs = ActivityLog::query()
            ->where('user_id', $this->user->id)
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('action', 'like', "%{$this->search}%")
                        ->orWhere('model_type', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhere('ip', 'like', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.user-management.logs.index', [
            'logs' => $logs,
            'user' => $this->user,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
