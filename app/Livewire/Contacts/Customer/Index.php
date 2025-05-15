<?php

namespace App\Livewire\Contacts\Customer;

use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

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
        $this->authorize('viewAny', Contact::class);

        $customers = Contact::query()
            ->where('type', 'customer') // Siempre filtra por 'customer'
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('full_name', 'like', '%' . $this->search . '%')
                             ->orWhere('email', 'like', '%' . $this->search . '%')
                             ->orWhere('phone_mobile', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    
        return view('livewire.contacts.customer.index', [
            'customers' => $customers,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
        ]);
    }
}
