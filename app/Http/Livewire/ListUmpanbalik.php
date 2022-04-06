<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Feedback;
use Livewire\WithPagination;

class ListUmpanbalik extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';
    public $byRating = null;
    public $perPage = 10;
    public $search = '';

    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.list-umpanbalik', [
            'feedbacks' => Feedback::when($this->byRating, function($query){
                $query->where('rating', $this->byRating);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),])
            ->extends('layouts.app')
            ->section('content');
    }
}
