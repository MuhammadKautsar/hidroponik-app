<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produk;
use Livewire\WithPagination;

class ListProduk extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function render()
    {
        return view('livewire.admin.list-produk', ['data_product' => Produk::search($this->search)
        ->orderBy('created_at', 'desc')->paginate($this->perPage),])
        ->extends('layouts.app')
        ->section('content');
    }
}
