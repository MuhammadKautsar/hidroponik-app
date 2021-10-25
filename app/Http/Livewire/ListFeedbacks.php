<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Feedback;
use App\Models\Produk;
use Livewire\WithPagination;

class ListFeedbacks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.list-feedbacks', ['feedbacks' => Feedback::search($this->search)
        ->paginate($this->perPage),], ['data_product' => Produk::all()])
        ->extends('layouts.app')
        ->section('content');
    }
}
