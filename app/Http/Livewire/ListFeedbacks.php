<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Feedback;
use Livewire\WithPagination;

class ListFeedbacks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.list-feedbacks', ['feedbacks' => Feedback::search($this->search)
        ->paginate($this->perPage),])
        ->extends('layouts.app')
        ->section('content');
    }
}
