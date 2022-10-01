<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class LivewireDatatable extends Component
{
    use WithPagination;

    public int $showPerPage = 20;
    public string $sortField = 'name';
    public bool $sortAsc = true;
    public string|null $currentPage = null;

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }
}
