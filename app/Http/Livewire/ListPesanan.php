<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;

class ListPesanan extends Component
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
        return view('livewire.admin.list-pesanan', [
            'data_order' => Order::when($this->byStatus, function($query){
                $query->where('status_order', $this->byStatus);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),])
            ->extends('layouts.app')
            ->section('content');
    }
}
