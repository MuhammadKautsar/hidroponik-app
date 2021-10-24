<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Promo;
use Livewire\WithPagination;

class ListProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.list-products', ['data_product' => Produk::search($this->search)
        ->paginate($this->perPage),], ['promo' => Promo::all()])
        ->extends('layouts.app')
        ->section('content');
    }
}
