<?php

namespace App\Traits;

use Livewire\Attributes\Url;

trait WithSorting
{
    #[Url]
    public string $sortBy = '';

    #[Url]
    public string $sortDirection = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }
}
