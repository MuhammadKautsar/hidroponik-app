<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Feedback;
use Livewire\WithPagination;

class ListUmpanbalik extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.admin.list-umpanbalik', ['feedbacks' => Feedback::search($this->search)
        ->orderBy('created_at', 'desc')->paginate($this->perPage),])
        ->extends('layouts.app')
        ->section('content');
    }
}
