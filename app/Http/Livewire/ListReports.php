<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use Livewire\WithPagination;

class ListReports extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.list-reports', ['data_report' => Report::search($this->search)
        ->paginate($this->perPage),])
        ->extends('layouts.app')
        ->section('content');
    }
}
