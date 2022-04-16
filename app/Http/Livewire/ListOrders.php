<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Produk;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ListOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';
    public $byStatus = null;
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
        return view('livewire.list-orders', [
            'data_order' => Order::when($this->byStatus, function($query){
                $query->where('status_order', $this->byStatus);
            })
            ->where('penjual_id', Auth::user()->id)
            ->search(trim($this->search))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),], ['data_product' => Produk::all()])
            ->extends('layouts.app')
            ->section('content');
    }
}
