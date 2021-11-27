<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Produk;
use Livewire\WithPagination;

class ListOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.list-orders', ['data_order' => Order::search($this->search)
        ->get(),], ['data_product' => Produk::all()])
        ->extends('layouts.app')
        ->section('content');
    }
}
