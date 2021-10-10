<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class ListOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.list-orders', ['data_order' => Order::search($this->search)
        ->paginate($this->perPage),])
        ->extends('layouts.app')
        ->section('content');
    }
}
